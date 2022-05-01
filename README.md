# octoi-phonebook

is a small collection of PHP scripts, that will parse the HTML table from the OCTOI Redmine wiki:
https://osmocom.org/projects/octoi/wiki/Phonebook  
  
The parser is located in:  
https://github.com/Manawyrm/octoi-phonebook/blob/main/phonebook.php

and all other files are exporters for various formats.  

Supported so far:  
- Auerswald Reverse Lookup
- Fritz!adr (.csv)
- Fritz!Box (.xml)
- Windows XP address book (german and english locale)

There is also a debug view (to check how the parser read the table) in [debug.php](https://phonebook.tbspace.de/debug.php).

![](https://screenshot.tbspace.de/dbtxnacpork.png)