import React from 'react';
import GuestLayout from "@/Layouts/GuestLayout.jsx";
import {Head} from "@inertiajs/react";

function Status({enroll}) {
    return (
        <GuestLayout>
            <Head title='Status'/>
            <div
                className="mt-6 md:mt-12 lg:mt-16 mx-auto w-full max-w-md overflow-hidden bg-white px-6 py-4 shadow-md rounded-lg border border-gray-200">
                {enroll && <><h2 className="text-xl font-semibold text-gray-800 mb-4">User Information</h2>
                    <div className="space-y-3">
                        <div>
                            <span className="text-sm font-medium text-gray-500">Name:</span>
                            <span className="ml-2 text-gray-700">{enroll.name}</span>
                        </div>
                        <div>
                            <span className="text-sm font-medium text-gray-500">NID:</span>
                            <span className="ml-2 text-gray-700">{enroll.nid}</span>
                        </div>
                        <div>
                            <span className="text-sm font-medium text-gray-500">Phone:</span>
                            <span className="ml-2 text-gray-700">{enroll.phone}</span>
                        </div>
                        <div>
                            <span className="text-sm font-medium text-gray-500">Email:</span>
                            <span className="ml-2 text-gray-700">{enroll.email}</span>
                        </div>
                        <div>
                            <span className="text-sm font-medium text-gray-500">Status:</span>
                            <span
                                className="ml-2 inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-md">{enroll.status}</span>
                        </div>
                        <div>
                            <span className="text-sm font-medium text-gray-500">Scheduled At:</span>
                            {enroll.schedule_at &&
                            <span
                                className="ml-2 inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-md">
       {enroll.schedule_at}
      </span> }
                        </div>
                    </div>
                </>}
                {!enroll && 'No enroll found!'}
            </div>

        </GuestLayout>
    );
}

export default Status;
