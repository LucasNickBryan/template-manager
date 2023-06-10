<?php

namespace Tests\Unit;

use App\Http\Controllers\TemplateManagerController;
use App\Models\Destination;
use App\Models\Quote;
use App\Models\Template;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    /**
     * Init the mocks
     */
    public function setUp(): void
    {
    }

    /**
     * Closes the mocks
     */
    public function tearDown(): void
    {
    }

    /**
     * @test
     */
    public function test()
    {
        $faker = Factory::create();

        $destinationId       = $faker->randomNumber();
        $expectedDestination = Destination::find($destinationId);
        $expectedUser        = auth()->user(); // given by lavarel passport

        $quote_data = [
            'site_id'        => $faker->randomNumber(),
            'destination_id' => $destinationId,
            'date_quoted'    => $faker->date()
        ];

        $quote = Quote::create($quote_data);

        $template = Template::create([
            1,
            'Your delivery to [quote:destination_name]',
            "
        Hi [user:first_name],

        Thanks for contacting us to deliver to [quote:destination_name].

        Regards,

        SAYNA team
        "
        ]);

        $message = (new TemplateManagerController)->getTemplateComputed(
            $template,
            [
                'quote' => $quote
            ]
        );

        $this->assertEquals('Your delivery to ' . $expectedDestination->countryName, $message->subject);
        $this->assertEquals(
            " Hi " . $expectedUser->firstname . ", Thanks for contacting us to deliver to " . $expectedDestination->countryName . ". Regards, SAYNA team ",
            $message->content
        );
    }
}
