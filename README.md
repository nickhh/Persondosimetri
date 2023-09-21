# Persondosimetri
Persondosimetri til personale på nuklearmedicinske afdelinger

# Prerequisites
  * Det anbefales persondosimetri softwaren køres i docker, da alle dependencies er opsat i dockerfilen.
Ønskes softwaren at køres på en dedikeret server, kræves der php8, mysqli og LDAP.
Se evt dockerfile.

  * En mysql eller MariaDB database 

# Installation (docker)
```
docker build -t persondosimetri https://github.com/nickhh/Persondosimetri && sudo docker run -d -t -i \
-e name=value_here \
-e node_class=value_here \
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


# License
Hospital Use License Clause:

This software is provided under the terms of the GNU General Public License, version 3 (GPL-3.0), with the additional provision that it may be freely used, modified, and distributed for non-commercial purposes within hospitals and healthcare institutions. However, commercial use, including resale or significant modifications that could impact patient safety, regulatory compliance, or the core functionality of the software, is prohibited without obtaining a separate commercial license from the copyright holder.

By using this software, you agree to abide by the terms of the Hospital Use License Clause.
