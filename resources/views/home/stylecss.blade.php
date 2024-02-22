<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    .wrapper {
        width: 380px;
        /* mengurangi lebar wrapper */
    }

    .wrapper header {
        display: flex;
        align-items: center;
        padding: 10px 30px 10px;
        justify-content: space-between;
    }

    header .icons {
        display: flex;
    }

    header .icons span {
        height: 38px;
        width: 38px;
        margin: 0 5px;
        cursor: pointer;
        color: #878787;
        text-align: center;
        line-height: 38px;
        font-size: 1.9rem;
        user-select: none;
        border-radius: 50%;
    }

    .icons span:last-child {
        margin-right: -10px;
    }

    header .icons span:hover {
        background: #f2f2f2;
    }

    header .current-date {
        font-size: 1.2rem;
        font-weight: 500;
        color: #787BFF;
    }

    .calendar {
        /* padding: 10px; */
        text-align: center;
        font-size: 1rem;
        margin-left: -20px;
        font-size: 1rem;
        /* mengatur kalender ke tengah */
    }

    .calendar ul {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        text-align: center;
    }

    .calendar .days {
        margin-bottom: 20px;
    }

    .calendar li {
        color: #333;
        width: calc(100% / 7);
        font-size: 1.07rem;
    }

    .calendar .weeks li {
        font-weight: 500;
        cursor: default;
    }

    .calendar .days li {
        z-index: 1;
        cursor: pointer;
        position: relative;
        margin-top: 13px;
        font-size: 1rem

    }

    .days li.inactive {
        color: #aaa;
    }

    .days li.active {
        color: #fff;
    }

    .days li::before {
        position: absolute;
        content: "";
        left: 50%;
        top: 50%;
        height: 40px;
        width: 40px;
        z-index: -1;
        border-radius: 50%;
        transform: translate(-50%, -50%);
    }

    .days li.active::before {
        background: #787BFF;
    }

    .days li:not(.active):hover::before {
        background: #f2f2f2;
    }
</style>
