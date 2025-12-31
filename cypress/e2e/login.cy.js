describe('Login LMS', () => {

  it('Menampilkan halaman login', () => {
    cy.visit('http://127.0.0.1:8000/login');

    // Assertion yang BENAR
    cy.contains('Masuk ke LearnFlux');
  });

  it('Login dengan data benar', () => {
    cy.visit('http://127.0.0.1:8000/login');

    cy.get('input[name="email"]').type('dinas@seed.test');
    cy.get('input[name="password"]').type('password');

    cy.get('button[type="submit"]').click();

    // Validasi berhasil login
    cy.url().should('include', '/dashboard');
    cy.contains('Dashboard');
  });

});