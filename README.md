# StabDex API
unfancy pokedex API for battle lovers

# Philosophy
Instead of providing a thorough and complete pokedex, StabDex takes a minimalistic approach, where only the absolute necessary for PM battles is retained. Other features which aid in the construction of competitive teams are also added to a minimum degree:
1. Powerful query engine: you can filter pokemon results with a very succinct filter language to get almost anything you want. From "pokemon builds who out-speed max EV 0 IV Garchomp" to "what pokemons can be =2HKed by my extreme SpAtk Chandelure and cannot hurt back", my dex is there to answer.
2. Patching system: a signed-up power user can easily maintain their own copy of the dex through a patch. They could also release their patches to let others base on them. One can navigate to changes made easily by utilizing diff tools. This way, hack maintainers can make their edits readily visible to the public, as well as making it available to redistributed hackers.

# Filter Language Syntax
This is an expression only domain specific (mini) language.
expression ::= [ "(" ], name, comparator, value, { separator, expression }, [ ")" ];
name ::= [ "(" ], word, { operator, name }, [ ")" ];
operator ::= "+" | "-" | "/" | "*";
comparator ::= "=" | "=" | ",=" | "" | "," | "!=";
value ::= integer, [ ".", { digit }, digit-without-zero ];
separator ::= ";" | "|";
integer ::= "0" | [ "-" ], digit-without-zero, { digit };
digit-without-zero = "1" | "2" | "3" | "4" | "5" | "6" | "7" | "8" | "9";
digit = "0" | digit-without-zero;
letter = "A" | "B" | "C" | "D" | "E" | "F" | "G" | "H" | "I" | "J" | "K" | "L" | "M" | "N" | "O" | "P" | "Q" | "R" | "S" | "T" | "U" | "V" | "W" | "X" | "Y" | "Z" | "a" | "b" | "c" | "d" | "e" | "f" | "g" | "h" | "i" | "j" | "k" | "l" | "m" | "n" | "o" | "p" | "q" | "r" | "s" | "t" | "u" | "v" | "w" | "x" | "y" | "z" ;
word = letter, { letter } | word, "_", word;