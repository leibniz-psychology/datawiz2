# Datawiz2 Semantic Versioning Changelog

## [2.0.1](https://github.com/leibniz-psychology/datawiz2/compare/v2.0.0...v2.0.1) (2025-02-04)


### Bug Fixes

* change broken link from study description to export ([48f562f](https://github.com/leibniz-psychology/datawiz2/commit/48f562f02a7102e286c1ffa8d4b35dbabfc0f2a5))
* replace deprecated Route Annotation with Route Attribute ([21a1816](https://github.com/leibniz-psychology/datawiz2/commit/21a181609e0ea9b4187ec679bc45f571eda6029f))
* return right type from DataWizUser getUserIdentifier ([4640ad7](https://github.com/leibniz-psychology/datawiz2/commit/4640ad78aabe565a4ff14fe1c6e3e12bfbea5b3b))

# [2.0.0](https://github.com/leibniz-psychology/datawiz2/compare/v1.0.0...v2.0.0) (2023-07-19)


### Bug Fixes

* convert data in doctrine migration Version20230428165114 ([1f928f8](https://github.com/leibniz-psychology/datawiz2/commit/1f928f897ff49be0c1805b338a4e0900e84791a2))
* datasets are being mistaken as wrong type ([13611ce](https://github.com/leibniz-psychology/datawiz2/commit/13611cecc9be9d083831138506ca7b02541c1536))
* files with long names make the delete button invisible ([2b1acdc](https://github.com/leibniz-psychology/datawiz2/commit/2b1acdcaaa1bdcc756387c080d335b544f7d7d8d)), closes [#3430](https://github.com/leibniz-psychology/datawiz2/issues/3430)
* remove button no longer jumps around when deleting widget ([a06e970](https://github.com/leibniz-psychology/datawiz2/commit/a06e9706a40ce954197317c4f2ecf93a465bd8d9)), closes [#3342](https://github.com/leibniz-psychology/datawiz2/issues/3342)
* update standard admin account ([d9614fc](https://github.com/leibniz-psychology/datawiz2/commit/d9614fc1972ecb4f1b58100124b658dba18d5ae0))


### Features

* add allowed methods to routes ([80b0c2b](https://github.com/leibniz-psychology/datawiz2/commit/80b0c2b5eec061698aabff48949117e7405be320))
* add beta warning text on front page ([0700713](https://github.com/leibniz-psychology/datawiz2/commit/070071341cb07a34d8b98d2035cc61bec4965d27))
* improve file display ([c2aa778](https://github.com/leibniz-psychology/datawiz2/commit/c2aa77894570a77ce5a3ed45fb6486747ad14cce))
* use different adapters for file uploads ([d309eaa](https://github.com/leibniz-psychology/datawiz2/commit/d309eaa70b24d886ad5b6ed56acef54ccbcc5c0b))
* use different folders for datasets and materials ([5fb8056](https://github.com/leibniz-psychology/datawiz2/commit/5fb8056ce783ba9474da3427cf8b432dcc514020))


### BREAKING CHANGES

* datasets and materials have to be moved to their respective new folders
