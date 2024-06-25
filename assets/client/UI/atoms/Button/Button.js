import React from 'react';

const Button = ({ type=`button`, click=()=>{}, customClass, children }) => {

    return <button
        type={type}
        onClick={click}
        className={`${customClass}`}
    >
        {children}
    </button>
}

export default Button;
