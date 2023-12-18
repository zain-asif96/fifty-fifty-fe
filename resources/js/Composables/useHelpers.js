import { countries } from "@/helpers/countries";
import { request } from "@/helpers/requestHelper.js";

export const useHelpers = () => {
    const getURLParam = (param) => {
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });

        return params[param];
    };

    const getCountryLabelByCode = (code) => {
        const country = countries.find((countryObject) => {
            return countryObject.value === code;
        });

        return country?.label || "";
    };

    const getCodeLabelByCountry = (code) => {
        const country = countries.find((countryObject) => {
            return countryObject.label === code;
        });

        return country?.value || "";
    };

    const getAllCountriesAdmin = async (page = "1", limit = "20") => {
        // let query = "";
        // if (page) {
        //     query = `page=${page}`;
        // }
        // if (limit) {
        //     query += `&limit=${limit}`;
        // }
        try {
            let res = await request({
                type: "get",
                url: `countries/all/countries`,
            });
            if (res?.data?.data) {
                let data = res?.data?.data?.data;

                let country = { ...res?.data?.data, data };
                return country;
            }
            return [];
        } catch (error) {
            return [];
        }
    };

    const amountHumanReadableWithCurrency = (amount) => {
        return (amount / 100).toFixed(2);
    };

    return {
        getURLParam,
        getCountryLabelByCode,
        amountHumanReadableWithCurrency,
        getAllCountriesAdmin,
        getCodeLabelByCountry,
    };
};
