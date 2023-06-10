<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use RuntimeException;

class TemplateManagerController extends Controller
{
    /**
     * @param Template $tpl
     * @param array $data
     *
     * @return customized Template
     */
    public function getTemplateComputed(Template $tpl, $data)
    {
        if (!$tpl) {
            throw new RuntimeException('no tpl given');
        }

        $replaced = $tpl;
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    /**
     * @param string $text
     * @param array $data
     *
     * @return customized $text
     */
    private function computeText($text, $data)
    {
        $quote = Quote::find($data['quote']->id) ? $data['quote'] : null;

        if ($quote) {
            $usefulObject = (new SiteController)->getById($quote->site_id);
            $destinationOfQuote = (new DestinationController)->getById($quote->destination_id);

            if (strpos($text, '[quote:destination_link]')) {
                $destination = $destinationOfQuote;
            }

            $containsSummaryHtml = strpos($text, '[quote:summary_html]');
            $containsSummary     = strpos($text, '[quote:summary]');

            if ($containsSummaryHtml || $containsSummary) {
                if ($containsSummaryHtml) {
                    $text = str_replace(
                        '[quote:summary_html]',
                        $quote::renderHtml($quote),
                        $text
                    );
                }
                if ($containsSummary) {
                    $text = str_replace(
                        '[quote:summary]',
                        quote::renderText($quote),
                        $text
                    );
                }
            }

            strpos($text, '[quote:destination_name]') && $text = str_replace('[quote:destination_name]', $destinationOfQuote->countryName, $text);
        }

        if ($destination) {
            $text = str_replace('[quote:destination_link]', $usefulObject->url . '/' . $destination->country_name . '/quote//' . $quote->id, $text);
        } else {
            $text = str_replace('[quote:destination_link]', '', $text);
        }

        /*
         * USER
         * [user:*]
         */
        $_user  = User::find($data['user']->id);
        !$_user && $_user = auth()->user(); // by laravel passport
        if ($_user) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($_user->firstname)), $text);
        }

        return $text;
    }
}
