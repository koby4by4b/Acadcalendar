const receiver = document.getElementById('receiver');
const subject = document.getElementById('subject');
const message = document.getElementById('message');
const submit = document.getElementById('submit');

submit.addEventListener('submit',(e)=>{
    e.preventDefault();
    let ereceiver = `${receiver.value}`;
    let esubject = `${subject.value}`;
    let ebody = `
    <h3>This is an email notification from Acadcalendar, informing you of the following</h3>
    <br>
    ${message.value}
    <br>
    For more information, please contact acadcalendar.edu@gmail.com
    `;

    Email.send({
        SecureToken : "x", //add your token here
        To : ereceiver,
        From : "acadcalendar.edu@gmail.com",
        Subject : esubject,
        Body : ebody
    }).then(
      message => alert(message)
    );
});