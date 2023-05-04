describe('Login Test', () => {

	beforeEach(() => {
		cy.kcLogin(Cypress.env("username"), Cypress.env("password"));
		cy.request(Cypress.env("loginPath"));
	});

	it('Check Login', () => {
		cy.visit('/dashboard');
		cy.log(document.querySelector('h2'));
		cy.get('h2').contains('Dashboard');
	})

})