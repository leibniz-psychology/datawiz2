describe('Login Test', () => {

	before(() => {
		cy.kcLogin(Cypress.env("username"), Cypress.env("password"));
	});

	beforeEach(() => {
		cy.request(Cypress.env("loginPath"));
	});

	/*after(() => {
		cy.kcLogout();
	})*/

	it('Check Login', () => {
		cy.visit('/dashboard');
		cy.log(document.querySelector('h2'));
		cy.get('h2').contains('Dashboard');
	})

})