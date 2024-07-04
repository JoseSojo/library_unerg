import React from 'react';
import { 
    Button as BtnBoostrap
} from 'react-bootstrap'

const Button = ({ type=`button`, click=()=>{}, customClass, children, variant="primary",useBs=true }) => {

    if(useBs) {
        return <BtnBoostrap
            variant={variant}
            className={customClass}
            type={type}
            onClick={click}
        >
            {children}
        </BtnBoostrap>
    }

    return <BtnBoostrap
            className={customClass}
            type={type}
            onClick={click}
        >
            {children}
    </BtnBoostrap>
}

export default Button;
