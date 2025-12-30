<?php

namespace Tests\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\DataProvider;
//use Tests\TestCase;
use TypeError;

class HelperFunctionTest extends TestCase
{
    public function test_sum_helper_function_should_return_sum_of_two_integers()
    {
        $num1 =2;
        $num2 =3;
        $sum  = sum($num1, $num2);

        $this->assertEquals(5, $sum);
    }

    public function test_sum_helper_function_should_return_sum_of_two_floats(): void
    {
        $num1 =2.2;
        $num2 =3.3;
        $sum  = sum($num1, $num2);

        $this->assertEquals(5, $sum);
    }

    public function test_format_carbon_date_helper_function_should_return_valid_data()
    {
        $dateFormat ="Y-m-d";
        $carbonDate = Carbon::create(2025, 12, 21);
        $result     = formatCarbonDate($carbonDate);

        $this->assertSame($carbonDate, $result['raw']);
        $this->assertSame($carbonDate->diffForHumans(), $result['diff_for_human']);
        $this->assertSame($carbonDate->format($dateFormat), $result['date_string']);
    }

    public function test_format_carbon_date_helper_function_should_throw_type_error_when_integer_is_passed(): void
    {
        $input = 1;

        $this->expectException(\TypeError::class);

        formatCarbonDate($input);
    }

    public function test_format_carbon_date_helper_function_should_throw_type_error_when_string_is_passed(): void
    {
        $input = "helo";

        $this->expectException(\TypeError::class);

        formatCarbonDate($input);
    }

    public function test_format_carbon_date_helper_function_should_throw_type_error_when_array_is_passed(): void
    {
        $input = ["red", "blue", "yellow"];

        $this->expectException(\TypeError::class);

        formatCarbonDate($input);
    }

    public static function invalidInputProvider(): array
    {
        return [
            'null'    => [null],
            'string'  => ['not-a-carbon'],
            'integer' => [123],
            'array'   => [['2024-10-28']],
            'boolean' => [true],
            'object'  => [new \stdClass()],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_format_carbon_date_helper_function_should_throw_type_error($input): void
    {
        $this->expectException(\TypeError::class);

        formatCarbonDate($input);
    }
}
