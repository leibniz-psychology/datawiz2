// https://commitlint.js.org/#/reference-rules
module.exports = {
    extends: ['@commitlint/config-conventional'],
    "rules": {
        "scope-enum": [2, 'always', ['composer', 'yarn', 'actions', 'hooks', 'cypress']]
    }
}
