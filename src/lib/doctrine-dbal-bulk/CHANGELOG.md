## [Unreleased] - 2022-07-18

### Added
- [#110](https://github.com/flow-php/doctrine-dbal-bulk/pull/110) - **Updated to PHP 8.1** - [@norberttech](https://github.com/norberttech)
- [#88](https://github.com/flow-php/doctrine-dbal-bulk/pull/88) - **Added json_array doctrine type to bulk data** - [@owsiakl](https://github.com/owsiakl)
- [#87](https://github.com/flow-php/doctrine-dbal-bulk/pull/87) - **Detect JSON type values and automatically cast them from string to array in order to satisfy dbal** - [@norberttech](https://github.com/norberttech)
- [#86](https://github.com/flow-php/doctrine-dbal-bulk/pull/86) - **Update multiple rows at once** - [@DawidSajdak](https://github.com/DawidSajdak)
- [#28](https://github.com/flow-php/doctrine-dbal-bulk/pull/28) - **Workflow for aut-merging dependabot PRs** - [@tomaszhanc](https://github.com/tomaszhanc)
- [#23](https://github.com/flow-php/doctrine-dbal-bulk/pull/23) - **upsert on conflict columns** - [@norberttech](https://github.com/norberttech)
- [#9](https://github.com/flow-php/doctrine-dbal-bulk/pull/9) - **Add dependabot for tools** - [@tomaszhanc](https://github.com/tomaszhanc)

### Changed
- [#80](https://github.com/flow-php/doctrine-dbal-bulk/pull/80) - **Added more customizable abstraction for BulkInserts** - [@norberttech](https://github.com/norberttech)
- [#60](https://github.com/flow-php/doctrine-dbal-bulk/pull/60) - **Reuse workflows from aeon-php/actions** - [@tomaszhanc](https://github.com/tomaszhanc)
- [#47](https://github.com/flow-php/doctrine-dbal-bulk/pull/47) - **Deprecated errors from PHPStan** - [@tomaszhanc](https://github.com/tomaszhanc)
- [#8](https://github.com/flow-php/doctrine-dbal-bulk/pull/8) - **Update dependencies** - [@tomaszhanc](https://github.com/tomaszhanc)
- [#5](https://github.com/flow-php/doctrine-dbal-bulk/pull/5) - **Pass parameters types during executing database query** - [@tomaszhanc](https://github.com/tomaszhanc)
- [#5](https://github.com/flow-php/doctrine-dbal-bulk/pull/5) - **Updated dependencies** - [@tomaszhanc](https://github.com/tomaszhanc)
- [cdbc76](https://github.com/flow-php/doctrine-dbal-bulk/commit/cdbc76af8c863f40d6181aa81a60e4f1d33d6519) - **Initial commit** - [@norberttech](https://github.com/norberttech)

### Fixed
- [6ceb80](https://github.com/flow-php/doctrine-dbal-bulk/commit/6ceb8016a3519d63681ceb7ce6d20dee9e49cf4e) - **tools/composer.json - disabled plugins** - [@norberttech](https://github.com/norberttech)
- [820189](https://github.com/flow-php/doctrine-dbal-bulk/commit/820189c082972039c33d32e248db4a8b5ecef275) - **invalid dbal type in tests** - [@norberttech](https://github.com/norberttech)
- [338cf6](https://github.com/flow-php/doctrine-dbal-bulk/commit/338cf6f18f3124d864b99255e310224076bf5847) - **codding standard** - [@norberttech](https://github.com/norberttech)
- [afc893](https://github.com/flow-php/doctrine-dbal-bulk/commit/afc893652e5c457a53cce67b71a26d09b4f794ae) - **missing dependency** - [@norberttech](https://github.com/norberttech)
- [#84](https://github.com/flow-php/doctrine-dbal-bulk/pull/84) - **Use proper dbal types when executing insert statement allowing to bulk inser objects like DateTime** - [@norberttech](https://github.com/norberttech)
- [#7](https://github.com/flow-php/doctrine-dbal-bulk/pull/7) - **Github Action for checking PR description** - [@tomaszhanc](https://github.com/tomaszhanc)

### Updated
- [313cb8](https://github.com/flow-php/doctrine-dbal-bulk/commit/313cb82b2a41cdb1eff3f3f5b255c28f912f060c) - **dependencies** - [@norberttech](https://github.com/norberttech)
- [d8858c](https://github.com/flow-php/doctrine-dbal-bulk/commit/d8858c1d325837ec0fdf0943ec3dc9c9723bd38a) - **dependencies** - [@norberttech](https://github.com/norberttech)

### Removed
- [6b7826](https://github.com/flow-php/doctrine-dbal-bulk/commit/6b7826bbcb790977b98de38ad7533e0ecf36fe49) - **uuid dev dependency** - [@norberttech](https://github.com/norberttech)
- [28579b](https://github.com/flow-php/doctrine-dbal-bulk/commit/28579b10e771cab7cf5e3a27ac516e0ecf9d69ff) - **deprecated code** - [@norberttech](https://github.com/norberttech)
- [#47](https://github.com/flow-php/doctrine-dbal-bulk/pull/47) - **Support for Doctrine Dbal 2.x** - [@tomaszhanc](https://github.com/tomaszhanc)

Generated by [Automation](https://github.com/aeon-php/automation)