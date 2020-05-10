<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/1/8
 */

namespace Leading\Lib\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class LibCommand
 * @package Leading\Lib\Console
 */
abstract class LibCommand extends Command
{
    /**
     * @var ProgressBar
     */
    protected $bar;

    /**
     * 创建一个进度条
     *
     * @param int $max
     */
    public function createBar($max = 0)
    {
        $this->bar = $this->output->createProgressBar($max);
    }

    /**
     * 当前进度条执步数
     *
     * @param int $step
     */
    public function advanceBar(int $step = 1)
    {
        $this->bar->advance($step);
    }

    /**
     * 为了换行
     *
     * @return void
     */
    public function finishBar(): void
    {
        $this->bar->finish();
        $this->output->newLine();
    }
}