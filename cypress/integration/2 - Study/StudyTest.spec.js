import study from '../../fixtures/study.json'

describe('Study Test', () => {

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
		cy.get('#settings_shortName').clear().type(study.name);
		cy.get('#settings_submit').click()
		cy.get('span').should('contain', study.name);
	})

	it('Edit Study Basic information', () => {
		cy.visit('/studies');
		cy.get('a').contains(study.name).click();
		cy.get('#basic_information_title').clear().type(study.title);
		cy.get('#basic_information_description').clear().type(study.description);
		cy.get('#basic_information_related_publications_0').clear().type(study.relPub["0"]);
		cy.get('button').contains("Add another related publication +").click();
		cy.get('#basic_information_related_publications_3').clear().type(study.relPub["1"]);
		cy.get('#basic_information_creators_0_givenName').clear().type(study.creator.givenName);
		cy.get('#basic_information_creators_0_familyName').clear().type(study.creator.familyName);
		cy.get('#basic_information_creators_0_email').clear().type(study.creator.email);
		cy.get('#basic_information_creators_0_orcid').clear().type(study.creator.orcid);
		cy.get('#basic_information_creators_0_affiliation').clear().type(study.creator.affiliation);
		/* TODO CREDIT ROLES TEST */
		cy.get('#basic_information_submit').click();
	})

})