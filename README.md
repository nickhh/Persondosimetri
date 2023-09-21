# Persondosimetri
Persondosimetri til personale primært på nuklearmedicinske afdelinger
Softwaren er udviklet i Regionsyddanmark af Fysiker Thomas Lund Andersen & IT-Projektleder Nicklas Hauge Hansen

# Screenshots
![alt text](https://github.com/nickhh/Persondosimetri/blob/main/readme/overview.png "screenprint1")
![alt text](https://github.com/nickhh/Persondosimetri/blob/main/readme/overview2.png "screenprint2")
![alt text](https://github.com/nickhh/Persondosimetri/blob/main/readme/overview3.png "screenprint3")

# Prerequisites
  * Det anbefales persondosimetri softwaren køres i docker, da alle dependencies er opsat i dockerfilen.
Ønskes softwaren at køres på en dedikeret server, kræves der php8, mysqli og LDAP.
Se evt dockerfile.

  * En mysql eller MariaDB database 

# Installation (docker)
Nedenstående er et eksempel på hvordan systemet kan køres.
Det anbefales der opsættes SSL - dette er ikke med i eksemplet.
```
docker build -t persondosimetri https://github.com/nickhh/Persondosimetri && sudo docker run -d -t -i \
-e hospital_name=value_here \
-e hospital_location=value_here \
-e mysql_addr=value_here \
-e mysql_dosedb=value_here \
-e mysql_pass=value_here \
-e mysql_user=value_here \
-e ldap_basedn=value_here \
-e ldap_domain=value_here \
-e ldap_group=value_here \
-e ldap_host=value_here \
-p 80:80 \
--name Dosimetri persondosimetri
```
Miljøvariabler forklaret

```
"hospital_name"         : Hospitalets navn - dette bliver vist i footer på hjemmesiden
"hospital_location"     : Hospitalets placering - dette bliver vist i footer på hjemmesiden
"mysql_addr"            : Adressen til mysql/mariadb serveren
"mysql_dosedb"          : Databasens navn
"mysql_user"            : Brugernavn til database
"mysql_pass"            : Password til database
"ldap_basedn"           : BaseDN ex "dc=example,dc=com"
"ldap_domain"           : Domænenavn ex "example.com"
"ldap_group"            : Brugergruppe der giver adgang til persondosimetri
"ldap_host"             : Ldap serveren hostnavn/ip
```

# License
Hospital Use License Clause:

This software is provided under the terms of the GNU General Public License, version 3 (GPL-3.0), with the additional provision that it may be freely used, modified, and distributed for non-commercial purposes within hospitals and healthcare institutions. However, commercial use, including resale or significant modifications that could impact patient safety, regulatory compliance, or the core functionality of the software, is prohibited without obtaining a separate commercial license from the copyright holder.

By using this software, you agree to abide by the terms of the Hospital Use License Clause.
