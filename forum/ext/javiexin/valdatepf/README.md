# valdatepf
Validated Date Profile Fields

Adds validation to Date profile fields
* Minimum date
* Maximum date

In phpBB core, date profile fields "only" support a range of dates from today-100 years to today+50 years, and that is done inconsistently
(the validation is from 1901 to today+50 years, while the input ranges from today-100 years to today+100 years, making it impossible to
select a date in, say 1905 although it would be "valid", and you can select a date in, say 2100, but that will not validate).
This has been fixed in the core, but the fix will only be available starting with 3.1.11 and 3.2.1.

With this extension you fix the above, making the selectable dates the same as the "default" validation dates (1901 to today+50),
plus you get the possibility to mark a minimum full or partial date (year, year plus month or full date), and the possibility to mark
a maximum date (also, year, year plus month or full date), independent per each profile field.  The allowed input range will be made 
consistent with this selection, plus you have the option to enter dates as dropdowns (default) or as number fields (new), better for 
longer date ranges where the dropdown would be too long.  The selectable minimum and maximum are "not" limited (except the year must 
be between 1 and 9999) and hence the date values follow the selected ranges.  If a minimum or maximum value is entered, then the
corresponding field must be entered, that is, if a minimum year and month (but not day) are specified, then the selected date MUST
have a year and a month, but the day will not be required.  If a day minimum or maximum is specified, then the day would have to be
specified as well.  Note that this is NOT the same as making the field "required": you may not enter ANY value if the field is not
required, but if you do enter a value, it MUST have at least the same components as the specified validation range.

Note that, for backward compatibility, if you do not specify any minimum or maximum date, the selectable range will be the phpBB default
of 1901 to today plus 50 years.  If you want to make the field support ANY date, then specify the year 1 as minimum, and that will disable
the default check (make sure to use a number field type entry for this kind of profile fields, as the dropdown would be too big to handle).

There is absolutely no configuration needed.  Just install and enable, and all your existing date fields will automatically have the
possibility to add a validation range.  _NO USER DATA WILL BE LOST_.  To enable a (different than default) validation range you have to 
explicitly set the date range in each such profile field, and note that as with any other profile field type change, existing profile 
field values will NOT be validated nor changed in any way, until the user or admin explicitly changes the user profile individually.

If you remove this extension, all date profile fields will revert back to "standard" date profile fields, with the default validation
range, but _NO USER DATA WILL BE LOST_.

## Installation

Copy the extension to phpBB/ext/javiexin/valdatepf

Go to "ACP" > "Customise" > "Extensions" and enable the "Validated Date Profile Fields" extension.

## License

[GPLv2](license.txt)
