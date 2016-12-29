# StabDex API
unfancy pokedex API for battle lovers


# Philosophy
Instead of providing a thorough and complete pokedex, StabDex takes a minimalistic approach, where only the absolute necessary for PM battles is retained. Other features which aid in the construction of competitive teams are also added to a minimum degree:

1.  **Query engine**: you can filter pokemon results with a very succinct filter language to get almost anything you want. Currently only data retrieval queries are implemented, such as "give me the pokemons whose spAtk >= 100".
2.  **Patching system**: a signed-up power user can easily maintain their own copy of the dex through a patch. They could also release their patches to let others base on them. One can navigate to changes made easily by utilizing diff tools. This way, hack maintainers can make their edits readily visible to the public, as well as making it available to redistributed hackers.


# Filter Language Syntax
This is an expression only domain specific (mini) language. Grammar is represented in EBNF. clause represents the program.
```
letter = "A" | "B" | "C" | "D" | "E" | "F" | "G"
   | "H" | "I" | "J" | "K" | "L" | "M" | "N"
   | "O" | "P" | "Q" | "R" | "S" | "T" | "U"
   | "V" | "W" | "X" | "Y" | "Z" | "a" | "b"
   | "c" | "d" | "e" | "f" | "g" | "h" | "i"
   | "j" | "k" | "l" | "m" | "n" | "o" | "p"
   | "q" | "r" | "s" | "t" | "u" | "v" | "w"
   | "x" | "y" | "z" ;
digit-without-zero = "1" | "2" | "3" | "4" | "5" | "6" | "7" | "8" | "9";
digit = "0" | digit-without-zero;
identifier = letter, { letter | "_" | "-" };
number = "0" | [ "-" ], digit-without-zero, { digit }, [ ".", { digit }, digit-without-zero ];
operator = "+" | "-" | "/" | "*";
comparator = "<=" | ">=" | "<" | ">" | "=" | "!=";
separator = ";" | "|";
joiner = "," | "/";
operand = identifier | number | "(", lhs, ")";
lhs = operand, { operator, lhs };
rhs = number | identifier, { joiner, identifier };
expression = lhs, comparator, rhs | "(", clause, ")";
clause = expression, { separator, clause };
```

The EBNF representation is constructed to be formal. For those who can't careless (including the lazy me), here are valid programs and explanations:
```php
spd>=100 # you can have numbers in the right-hand-side.
tag=ou # and also identifiers.
tag=ou;type=grass|type=ghost # semicolon means AND. pipe means OR. This clause means give me all grass or ghost type pokemons in the OU tier. This will return Venusaur, Gengar, etc. Not just pokemons of grass/ghost dual type.
tag=ou,uber;type=grass/poison # comma is only used to join *named values* in the right-hand-side by UNION. Slash is the same but by INTERSECT. These are only added to save typing. INTERSECT *always* has higher precedence than UNION. so "type=grass/poison,ghost/poison" is valid. While "type=ou/uber,uu" is also valid, it is meaningless and returns nothing.
(tag=ou|tag=uber);type=grass;type=poison # exactly the same as above. Logic operators are *right associative*, so the first "|" is enclosed by parentheses. Otherwise, this would translate to "give me all pokemons that are in the uber tier with grass/poison dual typing. also return me all the pokemons in OU".
(spd+htp)/2<=100 # The best thing is that you can even do arithmetics in the left-hand-side with other identifiers and numbers. Better yet, parentheses are also available.
```