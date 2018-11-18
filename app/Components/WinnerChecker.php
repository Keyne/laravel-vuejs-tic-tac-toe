<?php
/**
 * Created by PhpStorm.
 * User: Keyne
 * Date: 17/11/2018
 * Time: 21:55
 */

namespace App\Components;


class WinnerChecker implements WinnerCheckerInterface
{
    /**
     * Number of rows and cols
     *
     * @var int
     */
    const BOARD_SIZE = 3;

    /**
     * Board's rows array positions $positions[$rowX][$colY]
     *
     * @const array
     */
    const POSITIONS_ROWS = [
        1 => [
            1 => 0,
            2 => 1,
            3 => 2,
        ],
        2 => [
            1 => 3,
            2 => 4,
            3 => 5,
        ],
        3 => [
            1 => 6,
            2 => 7,
            3 => 8,
        ],
    ];

    /**
     * Board's cols array positions $positions[$colY][$rowX]
     *
     * @const array
     */
    const POSITIONS_COLS = [
        1 => [
            1 => 0,
            2 => 3,
            3 => 6,
        ],
        2 => [
            1 => 1,
            2 => 4,
            3 => 7,
        ],
        3 => [
            1 => 2,
            2 => 5,
            3 => 8,
        ],
    ];

    /**
     * Board's diagonals array positions $positions[$colY][$rowX]
     *
     * @const array
     */
    const POSITIONS_DIAG = [
        1 => [
            1 => 0,
            2 => 4,
            3 => 8,
        ],
        3 => [
            1 => 2,
            2 => 4,
            3 => 6,
        ]
    ];

    /**
     * Checks if a player won the match
     *
     * @param  array $board
     * @param  int   $player
     * @return bool
     */
    public function check(array $board, int $player): bool
    {
        if ($this->checkRows($board, $player)
            || $this->checkCols($board, $player)
            || $this->checkDiagonals($board, $player)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Gets the row number (1, 2, 3) and returns its first position number
     *
     * @param  int $rowNumber
     * @return int
     */
    private function getRowStartPosition(int $rowNumber)
    {
        return self::POSITIONS_ROWS[$rowNumber][1];
    }

    /**
     * Gets the col's array position
     *
     * @param  int $x
     * @param  int $y
     * @return int
     */
    private function getColPosition(int $x, int $y): int
    {
        return self::POSITIONS_COLS[$y][$x];
    }

    /**
     * Gets the diagonal's array position
     *
     * @param  int $x
     * @param  int $y
     * @return int
     */
    private function getDiagonalPosition(int $x, int $y): int
    {
        return self::POSITIONS_DIAG[$y][$x];
    }

    /**
     * Checks rows for a winner
     *
     * @param  array $board
     * @param  int   $player
     * @return bool
     */
    private function checkRows(array $board, int $player): bool
    {
        for($rowNumber = 1; $rowNumber <= self::BOARD_SIZE; $rowNumber++) {
            $rowStart = $this->getRowStartPosition($rowNumber);

            for($i = $rowStart; $i < self::BOARD_SIZE + $rowStart; $i++){
                if ($board[$i] !== $player) {
                    break;
                }
                if ($i == $rowStart + 2) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checks cols for a winner
     *
     * @param  array $board
     * @param  int   $player
     * @return bool
     */
    private function checkCols(array $board, int $player): bool
    {
        for($y = 1; $y <= self::BOARD_SIZE; $y++) {
            for($x = 1; $x <= self::BOARD_SIZE ; $x++){
                $position = $this->getColPosition($x, $y);
                if ($board[$position] !== $player) {
                    break;
                }
                if ($x == self::BOARD_SIZE) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checks diagonals for a winner
     *
     * @param  array $board
     * @param  int   $player
     * @return bool
     */
    private function checkDiagonals(array $board, int $player): bool
    {
        foreach(self::POSITIONS_DIAG as $y => $row) {
            for($x = 1; $x <= self::BOARD_SIZE ; $x++){
                $position = $this->getDiagonalPosition($x, $y);
                if ($board[$position] !== $player) {
                    break;
                }
                if ($x == self::BOARD_SIZE) {
                    return true;
                }
            }
        }
        return false;
    }
}
