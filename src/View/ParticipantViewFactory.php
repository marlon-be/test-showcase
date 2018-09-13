<?php

namespace App\View;

final class ParticipantViewFactory
{
    public static function createForParticipantRows(array $participants) : array
    {
        $companies = [];

        foreach ($participants as $participant) {
            $view = static::createFromRow($participant);
            if (!isset($companies[$view->company])) {
                $companies[$view->company] = [];
            }

            $companies[$view->company][] = $view;
        }

        return $companies;
    }

    public static function createFromRow(array $participant) : ParticipantView
    {
        return new ParticipantView(
            $participant['name'],
            $participant['email'],
            $participant['company_name']
        );
    }
}
