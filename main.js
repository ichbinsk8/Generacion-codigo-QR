const contenerdorqr = document.getElementById('qrcode');

const QR = new QRCode(contenerdorqr);

const formulario = document.getElementById('btn')
const propetiario = document.getElementById('ownerName')

formulario.addEventListener('submit',(e)=>{
    e.preventDefault();
    QR.makeCode(formulario.ownerName.value);
})