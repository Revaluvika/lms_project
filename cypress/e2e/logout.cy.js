describe('Logout LMS', () => {

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('input[name="email"]').type('dinas@seed.test')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()

    // Pastikan login berhasil
    cy.url().should('include', '/dashboard')
  })

  it('User berhasil logout dari sistem', () => {
    cy.contains('Logout').click()

    // VALIDASI LOGOUT PALING BENAR
    cy.url().should('not.include', '/dashboard')
  })

})