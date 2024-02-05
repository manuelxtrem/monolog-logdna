<?php

namespace Zwijn\Monolog\Formatter;

use Monolog\DateTimeImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;

class LogdnaFormatterTest extends TestCase
{

  /**
   * @var \Zwijn\Monolog\Formatter\LogdnaFormatter
   */
  private $logdnaFormatter = null;

  protected function setUp(): void
  {
    parent::setUp();
    $this->logdnaFormatter = new \Zwijn\Monolog\Formatter\LogdnaFormatter();
  }

  public function testFormatAccordingToLogdnaStandard()
  {
    $record = $this->getRecord();
    $json = $this->logdnaFormatter->format($record);
    $decoded_json = \json_decode($json, true);

    $this->assertArrayHasKey('message', $decoded_json);
    $this->assertEquals($decoded_json['message'], $record['message']);
    $this->assertEquals($decoded_json['channel'], $record['channel']);
    $this->assertEquals($decoded_json['level'], $record['level']);
    $this->assertEquals($decoded_json['level_name'], $record['level_name']);
    $this->assertEquals($decoded_json['context'], $record['context']);
    $this->assertEquals($decoded_json['datetime'], $record['datetime']);
  }

  private function getRecord(): LogRecord
  {
    return new LogRecord(
      new DateTimeImmutable(false),
      'DEBUG',
      Level::fromName('DEBUG'),
      'some message',
      [],
      [],
    );
  }
}
