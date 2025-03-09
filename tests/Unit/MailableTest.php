<?php

use Illuminate\Mail\Mailables\Content;
use Mockery\MockInterface;
use Rochmadnf\Recail\Exceptions\DirectoryNullException;
use Rochmadnf\Recail\Exceptions\NodeNotFoundException;
use Rochmadnf\Recail\ReactMailable;
use Rochmadnf\Recail\Renderer;
use Symfony\Component\Process\ExecutableFinder;

it('renders the html and text from react-email', function () {
    (new TestMailable)
        ->assertSeeInHtml(EXPECTED_HTML, false)
        ->assertSeeInText('Hello from react email, test');
});

it('throws an exception if node executable is not resolved', function () {
    config()->set('react-email.node_path');

    $this->expectException(NodeNotFoundException::class);

    $this->instance(
        ExecutableFinder::class,
        Mockery::mock(ExecutableFinder::class, function (MockInterface $mock) {
            $mock->shouldReceive('find')->andReturn(null);
        })
    );

    (new TestMailable)->render();
});

it('prioritises configuration value over executable finder', function () {
    config()->set('react-email.node_path', '/path/to/node');

    expect(Renderer::resolveNodeExecutable())->toEqual('/path/to/node');
});

it('throws an exception if template directory path is null', function () {
    config()->set('react-email.template_directory', null);

    $this->expectException(DirectoryNullException::class);

    (new TestMailable)->render();
});

const EXPECTED_HTML = <<<'HTML'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en">
  <p style="font-size:14px;line-height:24px;margin:16px 0">Hello from react email, test</p>

</html>
HTML;

class TestMailable extends ReactMailable
{
    public function __construct(public array $user = ['name' => 'test'])
    {
        //
    }

    public function content()
    {
        return new Content('new-user');
    }
}
