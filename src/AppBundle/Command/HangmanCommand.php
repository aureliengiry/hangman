<?php

namespace AppBundle\Command;

use AppBundle\Entity\Player;
use AppBundle\Entity\PlayerRegistrationToken;
use AppBundle\Game\GameRunner;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class HangmanCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:play-hangman')
            ->setDescription('Play the Hangman in CLI :).')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->authenticate();

        $io = new SymfonyStyle($input, $output);

        $io->title('Welcome to the Hangman');

        $runner = $this->getContainer()->get(GameRunner::class);
        $game = $runner->loadGame(7);

        while (!$game->isOver()) {
            $str = '';
            foreach ($game->getWordLetters() as $letter) {
                $str .= ($game->isLetterFound($letter) ? $letter : '_').' ';
            }
            $io->text($str);

            $letterOrWord = $io->ask('Try a letter or a word', null, function ($value) {
                return $value;
            });

            if (1 === strlen($letterOrWord)) {
                $game->tryLetter($letterOrWord);
            } else {
                $game->tryWord($letterOrWord);
            }
        }

        if ($game->isWon()) {
            $io->success('You won, congrats!!');
        } else {
            $io->error('You failed! Bouhhhhh...');
        }
    }

    private function authenticate()
    {
        $player = new Player('CLI', '', '', new PlayerRegistrationToken());
        $token = new UsernamePasswordToken($player, '', 'main', ['ROLE_PLAYER']);

        $this->getContainer()->get('security.token_storage')->setToken($token);
    }
}
