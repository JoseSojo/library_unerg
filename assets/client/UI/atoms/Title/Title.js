import React from 'react';

const Title = ({ title, customClass }) => {

    return <h1
        className={`${customClass}`}
    >
        {title}
    </h1>
}

export default Title;

