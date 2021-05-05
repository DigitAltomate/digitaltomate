<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace AmeliaBooking\Application\Services\Placeholder;

use AmeliaBooking\Application\Services\Helper\HelperService;
use AmeliaBooking\Domain\Entity\User\AbstractUser;
use AmeliaBooking\Domain\Factory\User\UserFactory;
use AmeliaBooking\Infrastructure\Common\Exceptions\NotFoundException;
use AmeliaBooking\Infrastructure\Common\Exceptions\QueryExecutionException;
use Exception;
use Interop\Container\Exception\ContainerException;
use Slim\Exception\ContainerValueNotFoundException;

/**
 * Class PackagePlaceholderService
 *
 * @package AmeliaBooking\Application\Services\Notification
 */
class PackagePlaceholderService extends AppointmentPlaceholderService
{
    /**
     *
     * @return array
     *
     * @throws ContainerException
     */
    public function getEntityPlaceholdersDummyData()
    {
        /** @var HelperService $helperService */
        $helperService = $this->container->get('application.helper.service');

        return [
            'package_name'            => 'Package Name',
            'reservation_name'        => 'Package Name',
            'package_price'           => $helperService->getFormattedPrice(100),
            'package_description'     => 'Package Description',
            'reservation_description' => 'Package Description',
        ];
    }

    /**
     * @param array        $package
     * @param int          $bookingKey
     * @param string       $type
     * @param AbstractUser $customer
     *
     * @return array
     *
     * @throws ContainerValueNotFoundException
     * @throws NotFoundException
     * @throws QueryExecutionException
     * @throws ContainerException
     * @throws Exception
     */
    public function getPlaceholdersData($package, $bookingKey = null, $type = null, $customer = null)
    {
        return array_merge(
            $this->getPackageData($package),
            $this->getCompanyData(),
            $this->getCustomersData(
                $package,
                $type,
                0,
                $customer ? $customer : UserFactory::create($package['customer'])
            ),
            $this->getRecurringAppointmentsData($package, $bookingKey, $type, 'package'),
            [
                'icsFiles' => !empty($package['icsFiles']) ? $package['icsFiles'] : []
            ]
        );
    }

    /**
     * @param array $package
     *
     * @return array
     *
     * @throws ContainerValueNotFoundException
     * @throws ContainerException
     * @throws Exception
     */
    private function getPackageData($package)
    {
        /** @var HelperService $helperService */
        $helperService = $this->container->get('application.helper.service');

        $price = $package['price'];

        if (!$package['calculatedPrice'] && $package['discount']) {
            $subtraction = $price / 100 * ($package['discount'] ?: 0);

            $price = (float)round($price - $subtraction, 2);
        }

        return [
            'reservation_name'        => $package['name'],
            'package_name'            => $package['name'],
            'package_description'     => $package['description'],
            'reservation_description' => $package['description'],
            'package_price'           => $helperService->getFormattedPrice($price),
        ];
    }

    /**
     * @param array $package
     *
     * @param string $subject
     * @param string $body
     * @param int    $userId
     * @return array
     *
     * @throws NotFoundException
     * @throws QueryExecutionException
     */
    public function reParseContentForProvider($package, $subject, $body, $userId)
    {
        $employeeSubject = $subject;

        $employeeBody = $body;

        foreach ($package['recurring'] as $recurringData) {
            if ($recurringData['appointment']['providerId'] === $userId) {
                $employeeData = $this->getEmployeeData($recurringData['appointment']);

                $employeeSubject = $this->applyPlaceholders(
                    $subject,
                    $employeeData
                );

                $employeeBody = $this->applyPlaceholders(
                    $body,
                    $employeeData
                );
            }
        }

        return [
            'body'    => $employeeBody,
            'subject' => $employeeSubject,
        ];
    }
}
