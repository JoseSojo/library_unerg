
import React from 'react';
import Modal from 'react-bootstrap/Modal';
import { useModal } from '../../../context/ModalContext';
import { Badge } from 'react-bootstrap';
import Button from '../../atoms/Button/Button';

export default function ModalTemplate() {

    const modal = useModal();
    const work = modal.work;

    if(!work) return <></>
    const timestamp = work.date.timestamp;
    const testDate = new Date(timestamp * 1000)
    const date = testDate.toLocaleDateString();

    return (
        <Modal 
            show={modal.modal} className='w-100'
            size="lg"
            aria-labelledby="contained-modal-title-vcenter"
            centered
        >
            <Modal.Header>
                <Modal.Title>
                    <h3>{work.user.fullName} <Badge bg='light'>{date}</Badge></h3>
                    <h5>{work.category.id} - {work.category.name} - {work.program.name}</h5>
                    <h6>{work.investigationLine.name}</h6>
                </Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <h6>{work.title}</h6>
                <p>{work.resumenText}</p>
                <div className='d-flex p-3' style={{ gap:3 }}>
                    {
                        work.keyword.split(" ").map((item) => (
                            <Badge bg='light' className='shadow' style={{ color: "#281900" }}>{item}</Badge>
                        ))
                    }
                </div>
            </Modal.Body>
            <Modal.Footer>
                {
                    work.resumenDoc &&
                    <a
                        className='btn btn-primary'
                        download={`Resumen - ${work.title}`}
                        href={`/${work.document.webPath}`}
                    >
                        Descargar Resumen
                    </a>
                }
                {
                    work.downloader &&
                    <a
                        className='btn btn-primary'
                        download={`Trabajo - ${work.title}`}
                        href={`/${work.document.webPath}`}
                    >
                        Descargar Trabajo
                    </a>
                }
                <Button
                    useBs
                    click={modal.close}
                    type='button'
                    variant='danger'
                >
                    salir
                </Button>
            </Modal.Footer>
                
        </Modal>
    );
} 
