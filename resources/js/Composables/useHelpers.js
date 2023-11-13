import {countries} from "@/helpers/countries";

export const useHelpers = () => {

    const getURLParam = (param) => {
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop)
        });

        return params[param];
    }


    const getCountryLabelByCode = (code) => {
        const country = countries.find((countryObject) => {
            return countryObject.value === code;
        })

        return country.label;
    }

    const amountHumanReadableWithCurrency = (amount) => {
        return (amount / 100).toFixed(2);
    }

    return {
        getURLParam,
        getCountryLabelByCode,
        amountHumanReadableWithCurrency
    }
};
