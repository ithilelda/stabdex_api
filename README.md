# StabDex API
unfancy pokedex API for battle lovers
# Philosophy
Instead of providing a thorough and complete pokedex, StabDex trims down unnecessary information and retain only the bare minimum. However, this doesn't mean that StabDex is incomplete. On the contrary, it serves more complete information required in battles than most other dexes, from a type effectiveness chart to a very potent query engine. My goal is to provide a complete reference for people wanting to build their teams competitively.
# Basic Features
1. Powerful query engine: you can ask any question relating to battle. From "what's the most threatening pokemon to my team" to "how many pokemon builds out-sped my Garchomp". If my engine cannot answer a question you posted, then it is a BUG that ought to be fixed.
2. Patching system: a signed-up power user can easily maintain their own copy of the dex through a patch. They could also release their patches to let others base on them. One can navigate to changes made easily by utilizing diff tools. This way, hack maintainers can make their edits readily visible to the public, as well as making it available to redistributed hackers.
3. Usage statistic: any build used in a battle in the corresponding app (not yet available) will be recorded and available to be viewed by the public. This way, you can know what is truely popular and search for your way to counter. Better yet, you can ask a power user to patch a version to really nerf it! Statistics are stored in accordance to the patch version. So some OP PMs from a crazy hack will not affect vanilla stats.
# Simple API Documentation
This is currently the garbage ground for my api docs. Will move to somewhere more appropriate (i.e. wiki) later.

prefix: /api/a1 (version 1 alpha)

GET /pokemons : retrieve all pokemons in the database.

RUD operations on pokemons based on their pmid (these are the actual apis used):
GET /pokemon/{pmid:[0-9]+} : retrieve a specific pokemon by its pmid. A pokemon here stands for a specific form of a specific species.
PUT /pokemon/{pmid:[0-9]+} : update the specific form of a pokemon.
DELETE /pokemon/{pmid:[0-9]+} : delete a specific form of a pokemon.

CRUD on pokemons based on their nid and names (these are the apis user should use):
GET /pokemon/{nid:[0-9]+} : retrieve all pokemon forms with the same nid.
GET /pokemon/{name:[\-a-zA-Z]+} : retrieve a pokemon form by its name. notice that charizard, charizard-x, charizard-y are all different forms and this api will only retrieve the one specified by you.
POST /pokemon/{nid:[0-9]+} : add a new pokemon. The data is stored as its default form.
PUT /pokemon/{nid:[0-9]+} : update a pokemon's default form.
DELETE /pokemon/{nid:[0-9]+} : delete ALL forms of a pokemon.

GET /abilities : returns all abilities.
GET /abilities/{name:[a-zA-Z]+} : return all pokemon forms that has the ability {name}.

GET /ability/{name:[a-zA-Z]+} : return the detailed decription and mechanism data of the ability {name}.

GET /types : return the type chart.
GET /types/{name:[a-zA-Z]+} : return all pokemon forms of {name} type.
GET /types/{name1:[a-zA-Z]+}_{name2:[a-zA-Z]+} : return all pokemons of {name1}/{name2} double type. name1 name2 always come in id order.

GET /type/a_{name:[a-zA-Z]+} : return the effectiveness list of the type {name} as the attacker. Only returns single type data.
GET /type/r_{name:[a-zA-Z]+}[_{name:[a-zA-Z]+}] : [] optional. return the effectiveness list of the type(s) {name1}( and {name2}) as the defender. {name1} and {name2} order does not matter.
GET /type/r/{name:[a-zA-Z]+} : return all type( combinations) that resists the attack of type {name}. each entry will include the actual resistance (0, 1/2 or 1/4).
GET /type/r0/{name:[a-zA-Z]+} : return all type( combinations) that are immune to type {name}.
GET /type/r2/{name:[a-zA-Z]+} : return all type( combinations) that halve type {name} attack.
GET /type/r4/{name:[a-zA-Z]+} : return all type( combinations) that 1/4 type {name} attack.