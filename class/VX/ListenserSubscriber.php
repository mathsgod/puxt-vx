<?php

namespace VX;

use League\Event\ListenerRegistry;
use League\Event\ListenerSubscriber;
use R\DB\Event\AfterDelete;
use R\DB\Event\AfterInsert;
use R\DB\Event\AfterUpdate;
use R\DB\Event\BeforeInsert;
use R\DB\Event\BeforeUpdate;
use VX;

class ListenserSubscriber implements ListenerSubscriber
{
    private $vx;
    function __construct(VX $vx)
    {
        $this->vx = $vx;
    }

    public function subscribeListeners(ListenerRegistry $acceptor): void
    {
        $vx = $this->vx;
        $acceptor->subscribeTo(BeforeInsert::class, function (BeforeInsert $event) use ($vx) {
            $target = $event->target;

            if (property_exists($target, "created_time")) {
                $target->created_time = date("Y-m-d H:i:s");
            }

            if (property_exists($target, "created_by")) {
                $target->created_by = $vx->user_id;
            }
        });


        $acceptor->subscribeTo(BeforeUpdate::class, function (BeforeUpdate $event) use ($vx) {
            $target = $event->target;

            if (property_exists($target, "updated_time")) {
                $target->updated_time = date("Y-m-d H:i:s");
            }

            if (property_exists($target, "updated_by")) {
                $target->updated_by = $vx->user_id;
            }
        });

        $acceptor->subscribeTo(AfterInsert::class, function (AfterInsert $event) use ($vx) {
            if (!$event->target instanceof EventLog) {
                EventLog::LogInsert($event->target, $vx->user);
            }
        });

        $acceptor->subscribeTo(AfterUpdate::class, function (AfterUpdate $event) use ($vx) {
            if (!$event->target instanceof EventLog) {
                EventLog::LogUpdate($event->target, $vx->user);
            }
        });

        $acceptor->subscribeTo(AfterDelete::class, function (AfterDelete $event) use ($vx) {
            if (!$event->target instanceof EventLog) {
                EventLog::LogDelete($event->target, $vx->user);
            }
        });
    }
}