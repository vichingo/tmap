/**
 * @author milo van Loon
 */
jQuery.extend(jQuery.validator.messages, {
    required: "Dit veld is verplicht",
    remote: "Gelieve het veld te repareren.",
    email: "Gelieve een bestaand email adres in te geven.",
    url: "Gelieve een bestaande URL in te geven.",
    date: "Gelieve een bestaande datum in te geven.",
    dateISO: "Gelieve een bestaande datum in te geven (ISO).",
    number: "Gelieve een nummer in te geven.",
    digits: "Alleen letters aub.",
    creditcard: "Gelieve een juist Credit Card nummer in te geven.",
    equalTo: "Gelieve dezelfde waarde nog eens in te geven.",
    accept: "Gelieve een bestaande extensie in te geven.",
    maxlength: jQuery.validator.format("Gelieve niet meer dan {0} karakters in te geven."),
    minlength: jQuery.validator.format("Gelieve ten minste {0} karakters in te geven."),
    rangelength: jQuery.validator.format("Gelieve een waarde in te geven met een lengte tussen {0} en {1} karakter lang."),
    range: jQuery.validator.format("Gelieve een waarde in te geven tussen de {0} en {1}."),
    max: jQuery.validator.format("Gelieve een waarde in te geven die minder dan of gelijk is aan {0}."),
    min: jQuery.validator.format("Gelieve een waarde in te geven die meer dan of gelijk is aan {0}.")
});
