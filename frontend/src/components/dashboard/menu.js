import i18n from "../../i18n";

export default [
    {
        to: {name: 'dashboard.index'},
        icon: 'mdi-home',
        text:  i18n.t('scoliotracker.dashboard'),
    },
    {
        to: {name: 'dashboard.analytics.index'},
        icon: 'mdi-chart-line',
        text: i18n.t('scoliotracker.analytics'),
    },
    {
        to: {name: 'dashboard.workouts.index'},
        icon: 'mdi-arm-flex',
        text: i18n.t('scoliotracker.workout'),
    },
    {
        to: {name: 'dashboard.xrays.index'},
        icon: 'mdi-radiology-box',
        text: i18n.t('scoliotracker.xrays'),
    },
/*    {
        to: {name: 'dashboard.billing'},
        icon: 'mdi-credit-card',
        text: 'Billing',
    },
    {
        to: {name: 'dashboard.billing.select-plan'},
        icon: 'mdi-credit-card',
        text: 'Select Plan',
    },*/
]
