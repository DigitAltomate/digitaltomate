<?php

namespace AmeliaBooking\Application\Services\Bookable;

use AmeliaBooking\Domain\Collection\Collection;
use AmeliaBooking\Domain\Common\Exceptions\InvalidArgumentException;
use AmeliaBooking\Domain\Entity\Bookable\Service\PackageCustomer;
use AmeliaBooking\Domain\Entity\Bookable\Service\PackageCustomerService;
use AmeliaBooking\Domain\Entity\Booking\Appointment\Appointment;
use AmeliaBooking\Domain\Entity\Booking\Appointment\CustomerBooking;
use AmeliaBooking\Domain\Entity\Payment\Payment;
use AmeliaBooking\Domain\Services\DateTime\DateTimeService;
use AmeliaBooking\Infrastructure\Common\Container;
use AmeliaBooking\Infrastructure\Common\Exceptions\QueryExecutionException;
use AmeliaBooking\Infrastructure\Repository\Bookable\Service\PackageCustomerServiceRepository;
use AmeliaBooking\Infrastructure\Repository\Booking\Appointment\AppointmentRepository;
use Exception;
use Slim\Exception\ContainerValueNotFoundException;

/**
 * Class AbstractPackageApplicationService
 *
 * @package AmeliaBooking\Application\Services\Booking
 */
abstract class AbstractPackageApplicationService
{
    /** @var Container $container */
    public $container;

    /**
     * AbstractPackageApplicationService constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Collection $packageCustomerServices
     *
     * @return boolean
     *
     * @throws ContainerValueNotFoundException
     */
    abstract public function deletePackageCustomer($packageCustomerServices);

    /**
     * @param Collection $appointments
     *
     * @return void
     */
    abstract public function setPackageBookingsForAppointments($appointments);

    /**
     * @param CustomerBooking $booking
     *
     * @return boolean
     */
    abstract public function isBookingAvailableForPurchasedPackage($booking);

    /**
     * @param array $params
     *
     * @return array
     */
    abstract public function getPackageStatsData($params);

    /**
     * @param array      $packageDatesData
     * @param Collection $appointmentsPackageCustomerServices
     * @param int        $packageCustomerServiceId
     * @param string     $date
     * @param int        $occupiedDuration
     *
     * @return void
     */
    abstract public function updatePackageStatsData(
        &$packageDatesData,
        $appointmentsPackageCustomerServices,
        $packageCustomerServiceId,
        $date,
        $occupiedDuration
    );

    /**
     * @param Collection $appointments
     *
     * @return Collection
     *
     * @throws Exception
     */
    abstract public function getPackageCustomerServicesForAppointments($appointments);

    /**
     * @param Collection $appointments
     * @param array      $params
     *
     * @return array
     */
    abstract public function getPackageAvailability($appointments, $params);

    /**
     * @return array
     */
    abstract public function getPackagesArray();

    /**
     * @param array $paymentsData
     *
     * @return void
     *
     * @throws QueryExecutionException
     * @throws InvalidArgumentException
     */
    public function setPaymentData(&$paymentsData)
    {
        $packageCustomerIds = [];

        foreach ($paymentsData as $payment) {
            if (!$payment['appointmentId']) {
                $eventBookingIds[] = $payment['customerBookingId'];
            }

            if (!$payment['customerBookingId']) {
                $packageCustomerIds[] = $payment['packageCustomerId'];
            }
        }

        /** @var PackageCustomerServiceRepository $packageCustomerServiceRepository */
        $packageCustomerServiceRepository = $this->container->get('domain.bookable.packageCustomerService.repository');

        /** @var Collection $packageCustomerServices */
        $packageCustomerServices = $packageCustomerServiceRepository->getByCriteria(
            [
                'packagesCustomers' => $packageCustomerIds
            ]
        );

        /** @var AppointmentRepository $appointmentRepository */
        $appointmentRepository = $this->container->get('domain.booking.appointment.repository');

        /** @var Collection $appointments */
        $appointments = $appointmentRepository->getFiltered(
            [
                'packageCustomerServices' => $packageCustomerServices->keys(),
            ]
        );

        $paymentsIds = array_column($paymentsData, 'id');

        /** @var Appointment $appointment */
        foreach ($appointments->getItems() as $appointment) {
            /** @var CustomerBooking $booking */
            foreach ($appointment->getBookings()->getItems() as $booking) {
                /** @var PackageCustomerService $packageCustomerService */

                if ($booking->getPackageCustomerService()) {
                    $packageCustomerService = $packageCustomerServices->getItem(
                        $booking->getPackageCustomerService()->getId()->getValue()
                    );

                    /** @var Payment $payment */
                    $payment = $packageCustomerService->getPackageCustomer()->getPayment();

                    if ($payment && ($key = array_search($payment->getId()->getValue(), $paymentsIds)) !== false) {
                        $paymentsData[$paymentsIds[$key]]['bookingStart'] =
                            $appointment->getBookingStart()->getValue()->format('Y-m-d H:i:s');

                        $paymentsData[$paymentsIds[$key]]['providers'][$appointment->getProvider()->getId()->getValue()] = [
                            'id' => $appointment->getProvider()->getId()->getValue(),
                            'fullName' => $appointment->getProvider()->getFullName(),
                            'email' => $appointment->getProvider()->getEmail()->getValue(),
                        ];
                    }
                }
            }
        }
    }

    /**
     * @param Collection $packageCustomerServices
     * @param Collection $appointments
     *
     * @return array
     *
     * @throws ContainerValueNotFoundException
     * @throws InvalidArgumentException
     */
    public function getPackageUnusedBookingsCount($packageCustomerServices, $appointments)
    {
        $packageData = [];

        /** @var PackageCustomerService $packageCustomerService */
        foreach ($packageCustomerServices->getItems() as $packageCustomerService) {
            /** @var PackageCustomer $packageCustomer */
            $packageCustomer = $packageCustomerService->getPackageCustomer();

            $customerId = $packageCustomer->getCustomerId()->getValue();

            $serviceId = $packageCustomerService->getServiceId()->getValue();

            $packageId = $packageCustomer->getPackageId()->getValue();

            $id = $packageCustomerService->getId()->getValue();

            if (($packageCustomer->getEnd() ?
                    $packageCustomer->getEnd()->getValue() > DateTimeService::getNowDateTimeObject() : true) &&
                !isset($packageData[$customerId][$serviceId][$packageId][$id])) {
                $packageData[$customerId][$serviceId][$packageId][$id] = [
                    'count'      => $packageCustomerService->getBookingsCount()->getValue(),
                    'employeeId' => $packageCustomerService->getProviderId() ?
                        $packageCustomerService->getProviderId()->getValue() : null,
                    'locationId' => $packageCustomerService->getLocationId() ?
                        $packageCustomerService->getLocationId()->getValue() : null,
                    'start'      => $packageCustomer->getStart() ?
                        $packageCustomer->getStart()->getValue()->format('Y-m-d H:i') : null,
                    'end'        => $packageCustomerService->getPackageCustomer()->getEnd() ?
                        $packageCustomer->getEnd()->getValue()->format('Y-m-d H:i') : null,
                    'purchased'  => $packageCustomer->getPurchased() ?
                        $packageCustomer->getPurchased()->getValue()->format('Y-m-d H:i') : null,
                ];
            }
        }

        $customerData = [];

        if ($packageCustomerServices->length()) {
            /** @var Appointment $appointment */
            foreach ($appointments->getItems() as $appointment) {
                $serviceId = $appointment->getServiceId()->getValue();

                /** @var CustomerBooking $customerBooking */
                foreach ($appointment->getBookings()->getItems() as $customerBooking) {
                    if ($customerBooking->getPackageCustomerService() &&
                        $packageCustomerServices->keyExists(
                            $customerBooking->getPackageCustomerService()->getId()->getValue()
                        )
                    ) {
                        /** @var PackageCustomerService $packageCustomerService */
                        $packageCustomerService = $packageCustomerServices->getItem(
                            $customerBooking->getPackageCustomerService()->getId()->getValue()
                        );

                        $packageId = $packageCustomerService->getPackageCustomer()->getPackageId()->getValue();

                        $id = $packageCustomerService->getId()->getValue();

                        $customerId = $customerBooking->getCustomerId()->getValue();

                        if (!array_key_exists($customerId, $customerData)) {
                            $customerData[$customerId] = [
                                $serviceId => [
                                    $packageId => [
                                        $id => 1
                                    ]
                                ]
                            ];
                        } elseif (!array_key_exists($serviceId, $customerData[$customerId])) {
                            $customerData[$customerId][$serviceId] = [
                                $packageId => [
                                    $id => 1
                                ]
                            ];
                        } elseif (!array_key_exists($packageId, $customerData[$customerId][$serviceId])) {
                            $customerData[$customerId][$serviceId][$packageId] = [
                                $id => 1
                            ];
                        } elseif (!array_key_exists($id, $customerData[$customerId][$serviceId][$packageId])) {
                            $customerData[$customerId][$serviceId][$packageId][$id] = 1;
                        } else {
                            $customerData[$customerId][$serviceId][$packageId][$id] += 1;
                        }
                    }
                }
            }
        }

        $result = [];

        foreach ($packageData as $customerId => $customerValues) {
            foreach ($customerValues as $serviceId => $serviceValues) {
                foreach ($serviceValues as $packageId => $packageValues) {
                    foreach ($packageValues as $id => $values) {
                        $bookedCount = !empty($customerData[$customerId][$serviceId][$packageId][$id]) ?
                            $customerData[$customerId][$serviceId][$packageId][$id] : 0;

                        $result[$customerId][$packageId][$serviceId][$id] = array_merge(
                            $values,
                            [
                                'count' => $values['count'] - $bookedCount
                            ]
                        );
                    }
                }
            }
        }

        $parsedResult = [];

        foreach ($result as $customerId => $customerValues) {
            $customerPackagesServices = [
                'customerId' => $customerId,
                'packages'   => []
            ];

            foreach ($customerValues as $packageId => $serviceValues) {
                $packagesServices = [
                    'packageId' => $packageId,
                    'services'  => []
                ];

                foreach ($serviceValues as $serviceId => $packageValues) {
                    $services = [
                        'serviceId' => $serviceId,
                        'bookings'  => []
                    ];

                    foreach ($packageValues as $id => $values) {
                        $booking = array_merge(
                            ['id' => $id],
                            $values
                        );

                        $services['bookings'][] = $booking;
                    }

                    $packagesServices['services'][] = $services;
                }

                $customerPackagesServices['packages'][] = $packagesServices;
            }

            $parsedResult[] = $customerPackagesServices;
        }

        return $parsedResult;
    }
}
