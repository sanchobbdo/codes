Changelog
=========

1.0.3
-----

- Minor logic changes in Coder.
- Continous integration with travis-ci.
- Fixed bugs:
    - Use Symfony/Yaml instead of php extension in CodesFactory (tests).
    - Use class name instead of ```self``` in CodesConfiguration closure
      to support php-5.3.

1.0.2
-----

- Create a changelog (that's me :p).
- Update dependencies versions.
- Fill missing ```composer.json``` fields (tags, homepage, authors, etc).
- Use ```MockCoder``` instead of default ```Coder``` in tests.
- Create abstract ```CoderImplementationTestCase``` class.
- Other minor tests changes.

1.0.1
-----

- Improve and fix ```README.md```.
- Differentiate between **suggested** and **required** packages.

1.0.0
-----

- Initial commit.
