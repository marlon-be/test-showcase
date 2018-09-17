// This is an end-to-end test
// This tests basically follows the same flow an actual user would follow
// They span a much wider reach, which both means they would catch a lot of bugs, and they probably won't provide a lot of information on where the bug originated
// It is important to have end-to-end tests even when you have a 100% coverage in unit tests, as a system is more than the sum of its parts

describe('Participants', function() {
    it('does not show any participants', function() {
        cy.visit('/');
        cy.get('.alert-warning')
            .should('be.visible')
            .should('contain', 'No one here yet')
    });

    it('displays newly added participants', function() {
        cy.visit('/');

        cy.contains('Add participant').click();
        cy.get('input[name="create_participant[email]"]').type('brecht.bonte@marlon.be{enter}');

        cy.contains('Add participant').click();
        cy.get('input[name="create_participant[email]"]').type('ruben.haegeman@marlon.be{enter}');

        cy.contains('Add participant').click();
        cy.get('input[name="create_participant[email]"]').type('ruben.haegeman@cypress-users.be{enter}');

        cy.get('body')
            .should('contain', 'Marlon')
            .should('contain', 'Brecht Bonte')
            .should('contain', 'Ruben Haegeman')
            .should('contain', 'Cypress Users')
            .should('contain', 'Ruben Haegeman 2');
    });

    it('prevents adding participants with invalid email addresses', function() {
        cy.visit('/');
        cy.contains('Add participant').click();

        cy.get('input[name="create_participant[email]"]').type('just testing{enter}');

        cy.get('.invalid-feedback')
            .should('be.visible')
            .should('contain', 'This value is not a valid email address');
    });

    it('prevents adding participants twice', function() {
        cy.visit('/');
        cy.contains('Add participant').click();

        cy.get('input[name="create_participant[email]"]').type('brecht.bonte@marlon.be{enter}');

        cy.get('.invalid-feedback')
            .should('be.visible')
            .should('contain', 'Email already taken');
    });
});
