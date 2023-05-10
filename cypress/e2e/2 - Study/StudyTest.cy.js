import study from "../../fixtures/study.json";

describe("Study Test", () => {

  beforeEach(() => {
    cy.kcLogin(Cypress.env("username"), Cypress.env("password"));
    cy.request(Cypress.env("loginPath"));
  });

  it("Create new documentation", () => {
    cy.visit("/dashboard");
    cy.get("button").contains("Open data documentation tool").click();
    cy.get("h2").contains("Data documentation");
    cy.get("button").contains("Create new documentation").click();
    cy.get("#settings_shortName").clear().type(study.name);
    cy.get("#settings_submit").click();
    cy.get("span").should("contain", study.name);
  });

  it("Edit Study Basic information", () => {
    cy.visit("/studies");
    cy.get("a").contains(study.name).click();
    cy.get("#basic_information_title").clear().type(study.title);
    cy.get("#basic_information_description").clear().type(study.description);
    cy.get("button").contains("Add another related publication").click();
    cy.get("textarea[id^=basic_information_related_publications_]").each(
      ($el, index) => {
        cy.wrap($el).clear().type(study.relPub[index]);
      }
    );
    cy.get("#basic_information_creators_0_givenName")
      .clear()
      .type(study.creator.givenName);
    cy.get("#basic_information_creators_0_familyName")
      .clear()
      .type(study.creator.familyName);
    cy.get("#basic_information_creators_0_email")
      .clear()
      .type(study.creator.email);
    cy.get("#basic_information_creators_0_orcid")
      .clear()
      .type(study.creator.orcid);
    cy.get("#basic_information_creators_0_affiliation")
      .clear()
      .type(study.creator.affiliation);
    /* TODO CREDIT ROLES TEST */
    cy.get("#basic_information_submit").click();
  });

  it("Edit Study objectives", () => {
    cy.visit("/studies");
    cy.get("a").contains(study.name).click();
    cy.get("a").contains("Study goals").click();
    cy.get("#theory_objective").clear().type(study.theory_objective);
    cy.get("#theory_hypothesis").clear().type(study.theory_hypothesis);
    cy.get("#theory_submit").click();
  });

  it("Edit Study method", () => {
    /*
     * experimental
     */
    cy.visit("/studies");
    cy.get("a").contains(study.name).click();
    cy.get("a").contains("Study method").click();
    cy.get('label[for="method_research_design_0"]').click();
    cy.get("#method_experimentalDetails_0").click(); //Random assignment
    cy.get("#method_experimentalDetails_1").click(); //Non-random assignment
    cy.get("#method_experimentalDetails_2").click(); //Clinical trialClinical trial
    // Settings
    cy.get("#method_setting_0").click(); //Artificial setting
    cy.get("#method_setting_1").click(); //Real-life setting
    cy.get("#method_settingLocation")
      .clear()
      .type(study.method_settingLocation);
    cy.get("#method_submit").click();
    cy.get("#method_setting_2").click(); //Natural settingNatural setting
    cy.get("#method_settingLocation")
      .clear()
      .type(study.method_settingLocation);
    cy.get("#method_manipulations").clear().type(study.method_manipulations);
    // Design
    cy.get("#method_experimental_design_0").click(); //Independent measures / between-subjects design
    cy.get("#method_experimental_design_1").click(); //Repeated measures / within-subjects design
    cy.get("#method_experimental_design_2").click(); //Matched pairs design
    // Control Operations
    cy.get("#method_control_operations_0").click(); //None
    cy.get("#method_control_operations_1").click(); //Block randomization
    cy.get("#method_control_operations_2").click(); //Complete counterbalancing (all possible orders)
    cy.get("#method_control_operations_3").click(); //Incomplete counterbalancing (partial counterbalancing)
    cy.get("#method_control_operations_4").click(); //Latin Square
    cy.get("#method_control_operations_5").click(); //Latin Square using a random starting order with rotation (rotate order)
    cy.get("#method_control_operations_6").click(); //Reverse counterbalancing (ABBA-counterbalancing)
    cy.get('label[for="method_control_operations_7"]').click(); //Other
    cy.get("#method_otherControlOperations")
      .clear()
      .type(study.method_manipulations);
    cy.get("#method_submit").click();
    /*
     * non-experimental
     */
    cy.get('label[for="method_research_design_1"]').click();
    cy.get("#method_nonExperimentalDetails_1").click();
    cy.get("#method_nonExperimentalDetails_2").click();
    cy.get("#method_nonExperimentalDetails_3").click();
    cy.get("#method_nonExperimentalDetails_4").click();
    cy.get('label[for="method_nonExperimentalDetails_0"]').click();
    cy.get("#method_observationalType").select("Case-control study");
    cy.get("#method_submit").click();
    // Settings
    cy.get("#method_setting_0").click(); //Artificial setting
    cy.get("#method_setting_1").click(); //Real-life setting
    cy.get("#method_settingLocation")
      .clear()
      .type(study.method_settingLocation);
    cy.get("#method_submit").click();
    cy.get("#method_setting_2").click(); //Natural settingNatural setting
    cy.get("#method_settingLocation")
      .clear()
      .type(study.method_settingLocation);
    cy.get("#method_submit").click();
  });

  it("Edit Data collection", () => {
    cy.visit("/studies");
    cy.get("a").contains(study.name).click();
    cy.get("a").contains("Data collection").click();
    cy.get("button").contains("Add another measure").click().click();
    cy.get("textarea[id^=measure_measures_]").each(($el, index) => {
      cy.wrap($el)
        .clear()
        .type(study["measure_measures_" + index]);
      if (index === 1) {
        cy.wrap($el).siblings("button").click();
      }
    });
    cy.get("button").contains("Add another apparatus").click().click();
    cy.get("textarea[id^=measure_apparatus_]").each(($el, index) => {
      cy.wrap($el)
        .clear()
        .type(study["measure_apparatus_" + index]);
      if (index === 1) {
        cy.wrap($el).siblings("button").click();
      }
    });
    cy.get("#measure_submit").click();
  });
});
