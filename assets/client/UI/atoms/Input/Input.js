import React from 'react';

const Input = ({ customClass, type=`text`, change, name, value }) => {

    const ChageController = (e) => change ? change(e.target.value) : null;

    return <input 
        type={type}
        name={name}
        onChange={ChageController}
        className={`${customClass}`}
        value={value}
    />
}

export default Input;

