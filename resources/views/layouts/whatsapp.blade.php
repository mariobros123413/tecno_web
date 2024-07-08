<script>
function EnviarWhatsApp(number,mensaje) {
    const instanceId ='664AE71AF1FD4';
    const message = mensaje.replace(/"/g, "'");
    const token = '664603bea607f'; // tu token de acceso
    const url = `/proxy/send_message?number=${number}&type=text&message=${message}&instance_id=${instanceId}&access_token=${token}`;

    axios.post(url)
        .then(response => {
            if (response.data.status === 'success') {
              //  console.log('Message:', response.data.status);
            } else {
                console.error('Error en la respuesta de la API:', response.data.message);
            }
        })
        .catch(error => {
            console.error('Error al obtener el código QR:', error);
        });
}
</script>
