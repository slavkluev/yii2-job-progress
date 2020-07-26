# yii2-job-progress

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A Yii2 extension lets you know the progress of the job in a queue.

## Install

Via Composer

``` bash
$ composer require slavkluev/yii2-job-progress
```

You need to add progress behavior for queue component.
Update config file:

```php
'components' => [
    'queue' => [
        // ...
        'as progress' => \slavkluev\JobProgress\ProgressBehavior::class,
    ],
],
```

To add migrations to your application, edit the console config file to configure
a namespaced migration:

```php
'controllerMap' => [
    // ...
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => null,
        'migrationNamespaces' => [
            // ...
            'slavkluev\JobProgress\migrations',
        ],
    ],
],
```

Then apply new migrations:

``` bash
$ yii migrate
```

## Usage

``` php
class TestJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        \Yii::$app->queue->setProgressMax(100);
        for ($i = 0; $i < 100; $i++) {
            \Yii::$app->queue->incrementProgress();
            sleep(1);
        }
    }
}
```

If the job is completed and removed, you can find out the progress by $jobId.

``` php
$jobProgress = JobProgress::findByJobId($jobId);
echo $jobProgress->getProgressMax() . PHP_EOL;
echo $jobProgress->getProgressNow() . PHP_EOL;
echo $jobProgress->getPercent() . PHP_EOL;
```

## Documentations

``` php
// JobProgress methods
$jobProgress->getProgressMax();                     // Integer
$jobProgress->getProgressNow();                     // Integer
$jobProgress->getPercent();                         // Float

// Queue methods (Call from your Job)
\Yii::$app->queue->setProgressMax(int $value);      // Update the max number of progress.
\Yii::$app->queue->setProgressNow(int $value);      // Update the current number of progress.
\Yii::$app->queue->incrementProgress(int $offset);  // Increase current number of progress by $offset.
\Yii::$app->queue->getProgressMax();                // Integer
\Yii::$app->queue->getProgressNow();                // Integer
\Yii::$app->queue->getPercent();                    // Float
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email slavkluev@yandex.ru instead of using the issue tracker.

## Credits

- [Viacheslav Kliuev][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/slavkluev/yii2-job-progress.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/slavkluev/yii2-job-progress/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/slavkluev/yii2-job-progress.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/slavkluev/yii2-job-progress.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/slavkluev/yii2-job-progress.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/slavkluev/yii2-job-progress
[link-travis]: https://travis-ci.org/slavkluev/yii2-job-progress
[link-scrutinizer]: https://scrutinizer-ci.com/g/slavkluev/yii2-job-progress/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/slavkluev/yii2-job-progress
[link-downloads]: https://packagist.org/packages/slavkluev/yii2-job-progress
[link-author]: https://github.com/slavkluev
[link-contributors]: ../../contributors
