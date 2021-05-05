<?php

namespace AmeliaBooking\Application\Commands\Google;

use AmeliaBooking\Application\Commands\CommandHandler;
use AmeliaBooking\Application\Commands\CommandResult;
use AmeliaBooking\Application\Common\Exceptions\AccessDeniedException;
use AmeliaBooking\Domain\Entity\Entities;
use AmeliaBooking\Domain\Entity\Google\GoogleCalendar;
use AmeliaBooking\Infrastructure\Repository\Google\GoogleCalendarRepository;

/**
 * Class DisconnectFromGoogleAccountCommandHandler
 *
 * @package AmeliaBooking\Application\Commands\Google
 */
class DisconnectFromGoogleAccountCommandHandler extends CommandHandler
{
    /**
     * @param DisconnectFromGoogleAccountCommand $command
     *
     * @return CommandResult
     * @throws AccessDeniedException
     * @throws \AmeliaBooking\Infrastructure\Common\Exceptions\NotFoundException
     * @throws \AmeliaBooking\Infrastructure\Common\Exceptions\QueryExecutionException
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function handle(DisconnectFromGoogleAccountCommand $command)
    {
        if (!$this->getContainer()->getPermissionsService()->currentUserCanRead(Entities::EMPLOYEES)) {
            throw new AccessDeniedException('You are not allowed to read employee.');
        }

        $result = new CommandResult();

        /** @var GoogleCalendarRepository $googleCalendarRepository */
        $googleCalendarRepository = $this->container->get('domain.google.calendar.repository');

        $googleCalendar = $googleCalendarRepository->getByProviderId($command->getArg('id'));

        if (!$googleCalendar instanceof GoogleCalendar) {
            $result->setResult(CommandResult::RESULT_ERROR);
            $result->setMessage('Unable to delete google calendar.');

            return $result;
        }

        if ($googleCalendarRepository->delete($googleCalendar->getId()->getValue())) {
            $result->setResult(CommandResult::RESULT_SUCCESS);
            $result->setMessage('Google calendar successfully deleted.');
        }

        return $result;
    }
}
