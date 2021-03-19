<?php

namespace AmeliaBooking\Application\Commands\Booking\Appointment;

use AmeliaBooking\Application\Commands\CommandHandler;
use AmeliaBooking\Application\Commands\CommandResult;
use AmeliaBooking\Application\Services\TimeSlot\TimeSlotService;
use AmeliaBooking\Domain\Common\Exceptions\InvalidArgumentException;
use AmeliaBooking\Domain\Entity\Bookable\Service\Service;
use AmeliaBooking\Domain\Services\DateTime\DateTimeService;
use AmeliaBooking\Infrastructure\Common\Exceptions\QueryExecutionException;
use AmeliaBooking\Infrastructure\Repository\Bookable\Service\ServiceRepository;
use Exception;
use Interop\Container\Exception\ContainerException;

/**
 * Class GetTimeSlotsCommandHandler
 *
 * @package AmeliaBooking\Application\Commands\Booking\Appointment
 */
class GetTimeSlotsCommandHandler extends CommandHandler
{
    /**
     * @var array
     */
    public $mandatoryFields = [
        'serviceId'
    ];

    /**
     * @param GetTimeSlotsCommand $command
     *
     * @return CommandResult
     * @throws \Slim\Exception\ContainerValueNotFoundException
     * @throws ContainerException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws QueryExecutionException
     */
    public function handle(GetTimeSlotsCommand $command)
    {
        $result = new CommandResult();

        $this->checkMandatoryFields($command);

        /** @var TimeSlotService $timeSlotService */
        $timeSlotService = $this->container->get('application.timeSlot.service');
        /** @var \AmeliaBooking\Domain\Services\Settings\SettingsService $settingsDS */
        $settingsDS = $this->container->get('domain.settings.service');
        /** @var ServiceRepository $serviceRepository */
        $serviceRepository = $this->container->get('domain.bookable.service.repository');

        /** @var Service $service */
        $service = $serviceRepository->getByIdWithExtras($command->getField('serviceId'));

        $minimumBookingTimeInSeconds = $settingsDS
            ->getEntitySettings($service->getSettings())
            ->getGeneralSettings()
            ->getMinimumTimeRequirementPriorToBooking();

        $maximumBookingTimeInDays = $settingsDS
            ->getEntitySettings($service->getSettings())
            ->getGeneralSettings()
            ->getNumberOfDaysAvailableForBooking();

        $startDateTime = $timeSlotService->getMinimumDateTimeForBooking(
            DateTimeService::getCustomDateTimeObject($command->getField('startDateTime'))
                ->modify('-1 days')->format('Y-m-d H:i:s'),
            $command->getField('page') === 'booking' || $command->getField('page') === 'cabinet',
            $minimumBookingTimeInSeconds
        );

        $endDateTime = $timeSlotService->getMaximumDateTimeForBooking(
            $command->getField('endDateTime'),
            $command->getField('page') === 'booking' || $command->getField('page') === 'cabinet',
            $maximumBookingTimeInDays
        );

        $freeSlots = $timeSlotService->getFreeSlots(
            $service,
            $command->getField('locationId') ?: null,
            $startDateTime,
            $endDateTime,
            $command->getField('providerIds'),
            $command->getField('extras'),
            $command->getField('excludeAppointmentId'),
            $command->getField('group') ? $command->getField('persons') : null,
            $command->getField('page') === 'booking' || $command->getField('page') === 'cabinet'
        );

        $utcFreeSlots = [];

        if ($settingsDS->getSetting('general', 'showClientTimeZone') &&
            ($command->getField('page') === 'booking' || $command->getField('page') === 'cabinet')
        ) {
            foreach ($freeSlots as $slotDate => $slotTimes) {
                foreach ((array)$freeSlots[$slotDate] as $slotTime => $slotTimesProviders) {
                    $convertedSlotParts = explode(
                        ' ',
                        DateTimeService::getCustomDateTimeObjectInUtc($slotDate . ' ' . $slotTime)
                            ->format('Y-m-d H:i:s')
                    );

                    $utcFreeSlots[$convertedSlotParts[0]][$convertedSlotParts[1]] = $slotTimesProviders;
                }
            }
        }

        $result->setResult(CommandResult::RESULT_SUCCESS);
        $result->setMessage('Successfully retrieved free slots');
        $result->setData([
            'slots' => $utcFreeSlots ?: $freeSlots
        ]);

        return $result;
    }
}
