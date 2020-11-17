const months = [
    { id: "1", name: "January" },
    { id: "2", name: "February" },
    { id: "3", name: "March" },
    { id: "4", name: "April" },
    { id: "5", name: "May" },
    { id: "6", name: "June" },
    { id: "7", name: "July" },
    { id: "8", name: "August" },
    { id: "9", name: "September" },
    { id: "10", name: "October" },
    { id: "11", name: "November" },
    { id: "12", name: "December" }
];

const getYearsList = () => {
    let years = [];
    let currentYear = new Date().getFullYear();
    let startYear = currentYear - 15;
    let endYear = currentYear + 15;

    for (let i = startYear; i < endYear; i++) {
        years.push(i);
    }

    return years;
};

const data = {
    currentMonth: new Date().getMonth() + 1,
    currentYear: new Date().getFullYear(),
    months,
    years: getYearsList()
};

export { data };
