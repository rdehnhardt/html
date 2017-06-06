<?php namespace Rdehnhardt\Html;

use Collective\Html\HtmlServiceProvider as IlluminateHtmlServiceProvider;
use Rdehnhardt\Html\FormBuilder;

class HtmlServiceProvider extends IlluminateHtmlServiceProvider
{
    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->bind('form', function ($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->token());

            return $form->setSessionStore($app['session.store']);
        });
    }
}
