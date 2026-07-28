import './bootstrap';
import './ticket-print';

import Alpine from 'alpinejs';

import intlTelInput from "intl-tel-input";

import "intl-tel-input/dist/css/intlTelInput.css";

window.intlTelInput = intlTelInput;

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', () => {
    const telefonoInput = document.getElementById('whatsapp_numero');
    const codigoPaisInput = document.getElementById('whatsapp_codigo_pais');

    if (!telefonoInput || !codigoPaisInput) {
        return;
    }

    const iti = intlTelInput(telefonoInput, {
        initialCountry: 'mx',
        separateDialCode: true,
        nationalMode: true,
        formatAsYouType: true,
        countrySearch: true,

        loadUtils: () => import('intl-tel-input/utils'),
    });

    const codigoAnterior = codigoPaisInput.value;
    const numeroAnterior = telefonoInput.value.trim();

    if (codigoAnterior && numeroAnterior) {
        iti.setNumber(`${codigoAnterior}${numeroAnterior}`);
    }

    const actualizarCodigoPais = () => {
        const paisSeleccionado = iti.getSelectedCountryData();

        codigoPaisInput.value = paisSeleccionado.dialCode
            ? `+${paisSeleccionado.dialCode}`
            : '';
    };

    actualizarCodigoPais();

    telefonoInput.addEventListener('countrychange', actualizarCodigoPais);

    telefonoInput.closest('form')?.addEventListener('submit', () => {
        actualizarCodigoPais();

        const numeroInternacional = iti.getNumber();

        if (numeroInternacional) {
            const codigoPais = codigoPaisInput.value;

            telefonoInput.value = numeroInternacional.startsWith(codigoPais)
                ? numeroInternacional.slice(codigoPais.length)
                : telefonoInput.value.replace(/\D/g, '');
        }
    });
});