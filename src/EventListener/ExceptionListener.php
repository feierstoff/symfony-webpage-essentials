<?php

namespace feierstoff\SymPack\EventListener;

use feierstoff\SymPack\Exception\BadRequestException;
use feierstoff\SymPack\Exception\ForbiddenException;
use feierstoff\SymPack\Exception\NotFoundException;
use feierstoff\SymPack\Exception\UnauthorizedException;
use feierstoff\SymPack\Exception\ViolationException;
use feierstoff\SymPack\Response\BadRequestResponse;
use feierstoff\SymPack\Response\ExceptionResponse;
use feierstoff\SymPack\Response\ForbiddenResponse;
use feierstoff\SymPack\Response\NotFoundResponse;
use feierstoff\SymPack\Response\UnauthorizedResponse;
use feierstoff\SymPack\Response\ViolationResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface {
    public function onKernelException(ExceptionEvent $event) {
        $exception = $event->getThrowable();

        switch (true) {
            case $exception instanceof ForbiddenException:
                $event->setResponse(new ForbiddenResponse());
                return;
            case $exception instanceof NotFoundException:
                $event->setResponse(new NotFoundResponse());
                return;
            case $exception instanceof UnauthorizedException:
                $event->setResponse(new UnauthorizedResponse());
                return;
            case $exception instanceof ViolationException:
                $event->setResponse(new ViolationResponse($exception->getViolations()));
                return;
            case $exception instanceof BadRequestException:
                $event->setResponse(new BadRequestResponse());
                return;
            default:
                $event->setResponse(new ExceptionResponse($exception, "dev"));
        }
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::EXCEPTION => "onKernelException"
        ];
    }
}