Feature('register');
Scenario('Check required fields on registration form', ({ I }) => {
  I.amOnPage('http://localhost:8000/login');
  I.fillField('#email','feliciaryu33@gmail.com');
  I.fillField('#password', '1111');
  I.click('#login');
  I.seeInCurrentUrl('/adminPostList');
  I.click('#createUser'); 
  I.seeInCurrentUrl('http://localhost:8000/register'); 
  I.fillField('input[name="name"]', '');
  I.fillField('input[name="email"]', '');
  I.fillField('input[name="pw"]', '');
  I.fillField('input[name="profile"]', '');
  I.click('#register');
  I.see("Name can't be blank");
  I.see("Email can't be blank.");
  I.see("The password field can't be blank.");
  I.see("Profile image is required.");
});