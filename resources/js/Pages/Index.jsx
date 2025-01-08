import React, {useEffect, useState} from 'react';
import GuestLayout from "@/Layouts/GuestLayout.jsx";
import {Head, useForm} from "@inertiajs/react";
import Status from "@/Components/Enroll/Status.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

function Index() {

    const [enroll, setEnroll] = useState(null)
    const [loading, setLoading] = useState(false)

    const {data, setData, errors, setError,clearErrors} = useForm({
        nid: '1234567885', dob: '1998-12-14'
    })

    const onChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const submit = (e) => {
        e.preventDefault();
        setLoading(true)
        axios.post(route('api.v1.enrolls.status'), data)
            .then(response => response?.data)
            .then((response) => {
                setEnroll(response)
                clearErrors()
            })
            .catch(({response}) => {
                setEnroll(null)
                if (response.status === 422) {
                    const errors = response?.data?.errors || {}
                    Object.keys(errors).forEach((key) => {
                        setError(key, errors[key][0])
                    })
                }
                setError('nid', response.data.message || 'Something went wrong!')
            }).finally(() => {
            setLoading(false)
        })
    }

    return (<GuestLayout>
        <Head title='Vaccine System'/>
        <div
            className="mt-6 md:mt-12 lg:mt-16 mx-auto w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
            <form onSubmit={submit}>
                <div className="mt-4">
                    <InputLabel htmlFor="nid" value="NID"/>

                    <TextInput
                        id="nid"
                        type="text"
                        name="nid"
                        value={data.nid}
                        className="mt-1 block w-full"
                        onChange={onChange}
                    />

                    <InputError message={errors.nid} className="mt-2"/>
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="dob" value="DATE OF BIRTH"/>

                    <TextInput
                        id="dob"
                        type="date"
                        name="dob"
                        value={data.dob}
                        className="mt-1 block w-full"
                        onChange={onChange}
                    />

                    <InputError message={errors.dob} className="mt-2"/>
                </div>
                <div className="mt-4 flex items-center justify-end">
                    <PrimaryButton className="ms-4" disabled={loading}>
                        Check Status
                    </PrimaryButton>
                </div>
            </form>
        </div>


        {enroll && <div
            className="mt-6 md:mt-12 lg:mt-16 mx-auto w-full max-w-md overflow-hidden bg-white px-6 py-4 shadow-md rounded-lg border border-gray-200">
            <Status enroll={enroll}/>
        </div>
        }

    </GuestLayout>)

}

export default Index;
