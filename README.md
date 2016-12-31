# StabDex API
unfancy pokedex API for battle lovers


# Philosophy
Instead of providing a thorough and complete pokedex, StabDex takes a minimalistic approach, where only the absolute necessary for PM battles is retained. Other features which aid in the construction of competitive teams are also added to a minimum degree:

1.  **Query engine**: you can filter pokemon results with a very succinct filter expression to get almost anything you want. Due to design pricipals of REST, I only provide retrieval support, such as "give me the pokemons whose spAtk >= 100".
2.  **Patching system**: a signed-up power user can easily maintain their own copy of the dex through a patch. They could also release their patches to let others base on them. One can navigate to changes made easily by utilizing diff tools. This way, hack maintainers can make their edits readily visible to the public, as well as making it available to redistributed hackers.

## small note about the filter expression
The filter expression occurs in the query string of the supported endpoints. The name should be "filter", and the content is basically SQL in the WHERE section.
+ "identifier <|>|<=|>=|=|!= value" is the basic syntax. For example, "htp<100" or "spd!=80".
+ you can connect expressions by ";", semicolons. The AND operator is automatically applied. OR is currently not supported. if OR is added, presedence and associativity must be considered, and parentheses should be added to ease expression construction. However, it will require me to write simple lexer and parsers, which I don't want to do in PHP without acceptable library supports.
+ The expressions will be converted safely to SQL query's WHERE section. If anything not matching the definition is in the string, the entire string is discarded to prevent malicious behavior.
+ maximum query string is limited to 10 expressions to also prevent resource exhausting attacks. 10 is more than enough for pokemons.