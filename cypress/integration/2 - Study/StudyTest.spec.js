describe('Login Test', () => {

	let studyName = "Cypress Study";

	before(() => {
		cy.kcLogin(Cypress.env("username"), Cypress.env("password"));
	});

	beforeEach(() => {
		cy.request(Cypress.env("loginPath"));
	});

	/*after(() => {
		cy.kcLogout();
	})*/

	it('Create Study', () => {
		cy.visit('/dashboard');
		cy.get('button').contains("Open Data documentation").click()
		cy.get('h2').contains('My studies');
		cy.get('button').contains("Create new study").click()
		cy.get('#settings_shortName').clear().type(studyName);
		cy.get('#settings_submit').click()
	})

	it('Edit Study Basic information', () => {
		cy.visit('/studies');
		cy.get('a').contains(studyName).click();
		cy.get('#basic_information_title').clear().type("lorem ipsum");
		cy.get('#basic_information_description').clear().type("lorem ipsum");
		cy.get('#basic_information_related_publications_0').clear().type("lorem ipsum");
		cy.get('#basic_information_submit').click()
	})

})