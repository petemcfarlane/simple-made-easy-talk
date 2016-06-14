<?php

// Before

class Game
{
    private function handleBallPotted($state, BallPotted $event)
    {
        $ball = $event->getBall();
        $points = $ball->getValue();
        $lastEvent = $state[0];
        $player = $event->getPlayer();

        if ($ball instanceof RedBall) {
            $state[$player] += $points;
        } else {
            if ($lastEvent instanceof BallPotted && $lastEvent->getPlayer() == $player && $lastEvent->getBall() instanceof RedBall) {
                $state[$player] += $points;
            } else {
                if ($player == 1) {
                    $state[2] += max(4, $points);
                } else {
                    $state[1] += max(4, $points);
                }
            }
        }

        return $state;
    }
}

// After

class Game
{
    private function handleBallPotted(Score $currentScore, BallPotted $ballPotted, $lastEvent)
    {
        $points = $ballPotted->getBall()->getValue();
        $player = $ballPotted->byPlayer();

        if ($ballPotted->isRed() || $this->playerPreviouslyPottedRedBall($lastEvent, $player)) {
            return $currentScore->awardPointsToPlayer($points, $player);
        }

        return $currentScore->awardPointsToOpponent(max(4, $points), $player);
    }
}