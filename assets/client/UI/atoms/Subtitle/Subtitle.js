import React from 'react';

const Subtitle = ({ subtitle, customClass }) => {

    return <h2
        className={`${customClass}`}
    >
        {subtitle}
    </h2>
}

export default Subtitle;

