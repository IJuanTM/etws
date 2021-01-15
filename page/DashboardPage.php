<?php

use JetBrains\PhpStorm\Pure;

class DashboardPage
{
    // Create static variable kwh
    private static string $kwh;
    private static array $kwhArr = [];
    private static array $weekDateArr = [];
    private static array $weekEuroArr = [];

    // Function to get the kilowatt value from the data base, pushes it to calculate wattage function.
    public static function getDayKilowatt($date): string
    {
        // Make new variable from class Database
        $db = new Database();
        // Query to select the data from the kilowatt column in the etws_data table where the date is set to the date returned by the setDate function
        $db->query('SELECT kilowatt FROM etws_data WHERE date = :date AND product = :product');
        // Binds the pdo value date to the variable date
        $db->bind(':date', $date);
        $db->bind(':product', $_SESSION['product']);
        // Checks if query has returned anything
        if (!empty($db->single())) {
            $kwh = 0;
            foreach ($db->resultset() as $value) $kwh += $value['kilowatt'];
            self::$kwh = $kwh;
            // Returns a rounded kilowatt per hour as well as adding kWh at the end
            return number_format(self::$kwh, 2) . " kWh";
        } else {
            // Set the static variable kwh to be null
            self::$kwh = "";
            // Return "-" if query is empty
            return "-";
        }
    }

    // Print a informative text depending on the generated wattage
    #[Pure] public static function getDayText(): string
    {
        if (!empty(self::$kwh) && self::$kwh != "-") {
            $watt = self::$kwh * 1000;
            if ($watt < 50) return "Hiermee kunt u een 8 watt ledlamp wel " . number_format($watt / 8) . " uur laten branden!";
            elseif ($watt > 50 && $watt <= 200) return "Hiermee kunt u wel gemiddeld " . number_format($watt / 45) . " uur tv kijken!";
            elseif ($watt > 200 && $watt <= 400) return "Hiermee kunt uw smartphone wel gemiddeld " . number_format($watt / 20) . " keer opladen!";
            elseif ($watt > 400 && $watt <= 800) return "Hiermee kunt u wel " . number_format($watt / 65) . " keer uw laptop opladen!";
            elseif ($watt > 800 && $watt <= 2000) return "Uw kunt hiermee wel " . number_format(($watt / 800) * 12) . " keer uw eten voor 5 minuten in de magnetron opwarmen!";
            elseif ($watt > 2000 && $watt <= 4000) return "Hiermee kunt u wel " . number_format(($watt / 900) * 4) . " keer voor een kwartier uw huis stofzuigen!";
            else return "U kunt hiermee wel " . number_format($watt / 1500) . " keer voor een uur lang koken op een elektrische kookplaat!";
        } else return "Er is vandaag nog niets opgewekt.";
    }

    // Function to calculate the saved amount in euro
    #[Pure] public static function calcDayEuro(): string
    {
        // Check if kwh is not empty
        if (!empty(self::$kwh)) return "&plusmn; € " . number_format(COST * self::$kwh, 2);
        else return "-";
    }

    // --------------------------------------------------------------------------------------------

    // Function to display the right day to the table
    public static function selectWeekDate($col_day): bool|string
    {
        // Gets real day in numeric value with monday = 1, tuesday = 2, wedne...
        $real_day = date("N") - 1;
        // Checks if the current column is the same as the real day (-1, -2,-...)
        if ($col_day == $real_day) $date = DATE;
        elseif ($col_day == ($real_day - 1)) $date = date("Y-m-d", strtotime('-1 day', strtotime(DATE)));
        elseif ($col_day == ($real_day - 2)) $date = date("Y-m-d", strtotime('-2 day', strtotime(DATE)));
        elseif ($col_day == ($real_day - 3)) $date = date("Y-m-d", strtotime('-3 day', strtotime(DATE)));
        elseif ($col_day == ($real_day - 4)) $date = date("Y-m-d", strtotime('-4 day', strtotime(DATE)));
        elseif ($col_day == ($real_day - 5)) $date = date("Y-m-d", strtotime('-5 day', strtotime(DATE)));
        elseif ($col_day == ($real_day - 6)) $date = date("Y-m-d", strtotime('-6 day', strtotime(DATE)));
        else return "-";
        array_push(self::$weekDateArr, $date);
        return $date;
    }

    // Function to get the kilowatt value from the data base, pushes it to calculate wattage function.
    public static function getWeekKilowatt($date): string
    {
        // Make new variable from class Database
        $db = new Database();
        // Query to select the data from the kilowatt column in the etws_data table where the date is set to the date returned by the setDate function
        $db->query('SELECT kilowatt FROM etws_data WHERE date = :date AND product = :product');
        // Binds the pdo value date to the variable date
        $db->bind(':date', $date);
        $db->bind(':product', $_SESSION['product']);
        // Checks if query has returned anything
        if (!empty($db->single())) {
            $kwh = 0;
            foreach ($db->resultset() as $value) $kwh += $value['kilowatt'];
            self::$kwh = $kwh;
            // Push kwh in an array
            array_push(self::$kwhArr, self::$kwh);
            // Returns a rounded kilowatt per hour as well as adding kWh at the end
            return number_format(self::$kwh, 2) . " kWh";
        } else {
            // Set the static variable kwh to be null
            self::$kwh = "";
            // Return "-" if query is empty
            return "-";
        }
    }

    // Function to calculate the saved amount in euro
    public static function calcWeekEuro(): string
    {
        // Check if kwh is not empty
        if (!empty(self::$kwh)) {
            array_push(self::$weekEuroArr, COST * self::$kwh);
            // Returns a string with a rounded value in euro
            return "&plusmn; € " . number_format(COST * self::$kwh, 2);
        } else return "-";
    }

    // Calculate kwh total of the week
    #[Pure] public static function calcWeekKilowattTotal(): string
    {
        // Check if weekDateArr is not empty
        if (!empty(self::$weekDateArr)) {
            $total = 0;
            for ($i = 0; $i < count(self::$weekDateArr); $i++) {
                // Check if kwhArr is not empty
                if (isset(self::$kwhArr[$i])) $total += self::$kwhArr[$i];
                else continue;
            }
            return number_format($total, 2) . " kWh";
        } else return "-";
    }

    // Calculate savings from week
    #[Pure] public static function calcWeekEuroTotal(): string
    {
        // Check if weekDateArr is not empty
        if (!empty(self::$weekDateArr)) {
            $sum = 0;
            for ($i = 0; $i < count(self::$weekDateArr); $i++) {
                if (isset(self::$weekEuroArr[$i])) $sum += self::$weekEuroArr[$i];
                else continue;
            }
            return "&plusmn; € " . number_format($sum, 2);
        } else return "-";
    }

    // --------------------------------------------------------------------------------------------

    // Calc total month kwh
    public static function calcMonthKilowattTotal(): string
    {
        // Make new variable from class Database
        $db = new Database();
        // Query to select the data from the kilowatt column in the etws_data table where the date is set to any date in this month
        $db->query('SELECT kilowatt FROM etws_data WHERE date LIKE :date AND product = :product');
        // Binds the pdo value date to the variable date and binds product to the right user
        $db->bind(':date', date("Y-m-%"));
        $db->bind(':product', $_SESSION['product']);
        // Create a list of all returned items
        $kwh = 0;
        // Add each item in variable kwh
        foreach ($db->resultset() as $value) $kwh += $value['kilowatt'];
        // Returned calculated value
        return number_format($kwh, 2);
    }

    // Calc all total kwh
    public static function calcKilowattTotal(): string
    {
        // Make new variable from class Database
        $db = new Database();
        // Query to select all the data from the kilowatt column in the etws_data table
        $db->query('SELECT kilowatt FROM etws_data WHERE product = :product');
        // Binds the pdo value product to the session product
        $db->bind(':product', $_SESSION['product']);
        // Create a list of all returned items
        $kwh = 0;
        // Add each item in variable kwh
        foreach ($db->resultset() as $value) $kwh += $value['kilowatt'];
        // Returned calculated value
        return number_format($kwh, 2);
    }
}