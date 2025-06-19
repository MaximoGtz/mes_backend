const axios = require('axios');
const { JSDOM } = require('jsdom');

const urlToMonitor = 'http://192.168.0.1';
const postUrl = 'http://127.0.0.1:8000/api/insertions';

let lastData = null;

function parseData(html) {
    const dom = new JSDOM(html);
    const document = dom.window.document;
    const data = Array.from(document.querySelectorAll('#tiempos #listado')).map(el => el.textContent.trim());

    const extract = (label) => {
        const entry = data.find(d => d.startsWith(label));
        return entry ? entry.split(':')[1].trim() : null;
    };

    return {
        machine_number: parseInt(extract('NumberMachine')),
        recipe_number: parseInt(extract('NumberRecipe')),
        profile_length: parseFloat(extract('ProfileLength')),
        distance_between_holes: parseFloat(extract('DistanceBtwnHoles')),
        length_before_reset: parseFloat(extract('LengthBeforeReset')),
        good_piece: extract('HolesNOHoles') === '1',
        cicle_time: 3, // puedes ajustar este valor si tienes una forma de medirlo
        created_at: new Date().toISOString()
    };
}

function hasChanged(newData, oldData) {
    return JSON.stringify(newData) !== JSON.stringify(oldData);
}

async function monitor() {
    try {
        const response = await axios.get(urlToMonitor);
        const newData = parseData(response.data);

        if (hasChanged(newData, lastData)) {
            lastData = newData;

            const insertResponse = await axios.post(postUrl, newData);
            console.log('Datos insertados:', insertResponse.data);
        }
    } catch (error) {
        console.error('Error:', error.message);
    }
}

// Ejecutar cada 1.5 segundos
setInterval(monitor, 1500);
