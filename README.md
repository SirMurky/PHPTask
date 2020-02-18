# Paysera Commission task skeleton

Following steps:
- don't forget to change `Paysera` namespace and package name in `composer.json`
 to your own, as `Paysera` keyword should not be used anywhere in your task;
- `\Paysera\CommissionTask\Service\Math` is an example class provided for the skeleton and could or could not be used by your preference;
- needed scripts could be found inside `composer.json`;
- before submitting the task make sure that all the scripts pass (`composer run test` in particular);
- this file should be updated before submitting the task with the documentation on how to run your program.

Good luck! :) 
Thank you! :)

*IMPORTANT*
I decided to store currency rate values in .txt file which is located in src folder with all .php files. The problem is
that CurrencyConversion.php class has it's path specified which is my laptop's desktop.

Code documentation:
	I have created 4 classes: CashIn.php, CashOut.php, CurrencyConversion.php and Main.php
	CashIn class:
		It does operate only when "cash_in" is provided in .csv file. It does check the fee calculated and if it is more than 5 EUR, 
		we apply 5 EUR. If money is cashed in in different currency, we check how much is 5 EUR in that currency and then apply
		accordingly.
	CashOut class:
		It does calculate fees for both natural and legal person. The fee amount for legal is not less than 0.50 EUR, if cashed
		out in different currency, we check how much is 0.50 EUR in that currency.
	CurrencyConversion class:
		It does 2 things:
			1) It divides provided money amount(we use this when converting from currency to EUR);
			2) It multiplies provided money amount(we use this for fees, when converting from EUR to other currency);
	Main class:
		This class does all the handling. We provide the path to our .csv file and then it acts accordingly and calls
		according class method, for cash_in ->CashIn class for cash_out -> CashOut class.
		
Testing:
	It was my first time doing unit tests so I am not fully aware. 10 out of 12 tests pass, other 2 pass manually, but fail in
	composer. I provide 'natural' and 'legal' values in an array and my code does check whether it is natural or legal person
	that is operating, and for "other" types, we throw error message. When using unit test it does see all 'userType' values
	as "other".

Other notices:
		1) There is problem with comparing if cash flow is withing same week. When comparing weeks it does not
			see that month or even year can be different. If I add control to chech that it must be same month and same year
			then we get problem in other part where 2014.12.31 and 2015.01.01 is the same week...
		2) Minor issues using ceil and round
		3) For some reason my first data line in .csv file is in bad format. So I made 1st and second lines exactly the same
			and then on loop I skip first line. Not really sure if it is problems with my .csv files or this is something from PHP
			side that I am not aware of.
			
		Nevertheless was interesting learning something new :)
		Have a great day!
