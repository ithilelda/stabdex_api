# StabDex API
unfancy pokedex API for battle lovers


# Philosophy
Instead of providing a thorough and complete pokedex, StabDex takes a minimalistic approach, where only the absolute necessary for PM battles is retained. Other features which aid in the construction of competitive teams are also added to a minimum degree:

1.  **Query engine**: you can filter pokemon results with a very succinct filter language to get almost anything you want. Currently only data retrieval queries are implemented, such as "give me the pokemons whose spAtk >= 100".
2.  **Patching system**: a signed-up power user can easily maintain their own copy of the dex through a patch. They could also release their patches to let others base on them. One can navigate to changes made easily by utilizing diff tools. This way, hack maintainers can make their edits readily visible to the public, as well as making it available to redistributed hackers.


# Filter Language Syntax
This is an expression only domain specific (mini) language. Grammar is represented in EBNF. clause represents the program.

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
    equals = "=" | "!=";
    comparator = "<=" | ">=" | "<" | ">" | equals;
    separator = ";" | "|";
    operand = identifier | number | "(", lhs, ")";
    lhs = operand, { operator, lhs };
    rhs = number | identifier;
    expression = lhs, comparator, rhs | "(", clause, ")";
    clause = expression, { separator, clause };