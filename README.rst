Flask Cookie Decoder
====================

A decoder for signed session cookies created by Flask_/itsdangerous_,
implemented in PHP.

:Copyright: 2014-2015 Jan Ove Korneffel
:License: MIT, see LICENSE for details.
:Release date: 18-Oct-2015


Motivation
----------

Created to connect existing PHP web applications to the BYCEPS_ LAN
party platform, specifically its user and authorization subsystem.


Usage
-----

``require`` the PHP file in your code and call the ``decode_cookie`` function.


.. _Flask:        http://flask.pocoo.org/
.. _itsdangerous: https://pythonhosted.org/itsdangerous/
.. _BYCEPS:       https://github.com/homeworkprod/byceps
