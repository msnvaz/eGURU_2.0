 let feedbackData = [
            { 
                id: 1, 
                studentName: "Emily Johnson", 
                subject: "Mathematics", 
                message: "The last tutoring session was very helpful. I understood the algebra concepts much better.",
                timestamp: "2024-02-15 14:30",
                replies: [
                    { 
                        id: 1,
                        message: "Thank you for your feedback, Emily! I'm glad the session was helpful.",
                        timestamp: "2024-02-15 15:00"
                    }
                ]
            },
            { 
                id: 2, 
                studentName: "Michael Chen", 
                subject: "Physics", 
                message: "Could we spend more time on quantum mechanics in our next session?",
                timestamp: "2024-02-16 10:15",
                replies: [
                    { 
                        id: 2,
                        message: "Sure, Michael! We'll focus more on quantum mechanics in our next session.",
                        timestamp: "2024-02-16 11:00"
                    }
                ]
            }
        ];

        function renderFeedbackList() {
            const feedbackList = document.getElementById('feedbackList');
            feedbackList.innerHTML = '';

            feedbackData.forEach(feedback => {
                const feedbackItem = document.createElement('div');
                feedbackItem.classList.add('feedback-item');
                
                // Render student feedback
                feedbackItem.innerHTML = `
                    <div class="feedback-header">
                        <h3>${feedback.studentName} - ${feedback.subject}</h3>
                    </div>
                    <p>${feedback.message}</p>
                    <small>${feedback.timestamp}</small>
                `;

                // Create Reply Button
                const createReplyBtn = document.createElement('button');
                createReplyBtn.classList.add('btn', 'btn-create');
                createReplyBtn.textContent = 'Create Reply';
                createReplyBtn.onclick = () => showCreateReplyContainer(feedback.id);
                feedbackItem.appendChild(createReplyBtn);

                // Create Reply Container (initially hidden)
                const createReplyContainer = document.createElement('div');
                createReplyContainer.id = `createReplyContainer${feedback.id}`;
                createReplyContainer.classList.add('create-reply-container');
                createReplyContainer.style.display = 'none';
                createReplyContainer.innerHTML = `
                    <textarea id="newReplyInput${feedback.id}" class="reply-input" placeholder="Type your reply..."></textarea>
                    <button class="btn btn-create" onclick="createReply(${feedback.id})">Save Reply</button>
                    <button class="btn btn-cancel" onclick="cancelCreateReply(${feedback.id})">Cancel</button>
                `;
                feedbackItem.appendChild(createReplyContainer);

                // Render tutor replies
                feedback.replies.forEach((reply, index) => {
                    const replyElement = document.createElement('div');
                    replyElement.classList.add('tutor-reply');
                    replyElement.innerHTML = `
                        <div class="reply-actions">
                            <button class="btn btn-edit" onclick="startEditReply(${feedback.id}, ${reply.id})">Edit</button>
                            <button class="btn btn-delete" onclick="deleteReply(${feedback.id}, ${reply.id})">Delete</button>
                        </div>
                        <div id="replyContent${feedback.id}_${reply.id}">
                            <p>${reply.message}</p>
                            <small>${reply.timestamp}</small>
                        </div>
                    `;
                    feedbackItem.appendChild(replyElement);
                });

                feedbackList.appendChild(feedbackItem);
            });
        }

        function showCreateReplyContainer(feedbackId) {
            const createReplyContainer = document.getElementById(`createReplyContainer${feedbackId}`);
            createReplyContainer.style.display = 'block';
        }

        function cancelCreateReply(feedbackId) {
            const createReplyContainer = document.getElementById(`createReplyContainer${feedbackId}`);
            const replyInput = document.getElementById(`newReplyInput${feedbackId}`);
            createReplyContainer.style.display = 'none';
            replyInput.value = '';
        }

        function createReply(feedbackId) {
            const replyInput = document.getElementById(`newReplyInput${feedbackId}`);
            const newReplyMessage = replyInput.value.trim();

            if (newReplyMessage === '') {
                alert('Reply cannot be empty');
                return;
            }

            const feedback = feedbackData.find(f => f.id === feedbackId);
            
            // Generate a new unique ID for the reply
            const newReplyId = feedback.replies.length > 0 
                ? Math.max(...feedback.replies.map(r => r.id)) + 1 
                : 1;

            const newReply = {
                id: newReplyId,
                message: newReplyMessage,
                timestamp: new Date().toISOString().slice(0, 16).replace('T', ' ')
            };

            // Add the new reply
            feedback.replies.push(newReply);

            // Reset and hide the create reply container
            replyInput.value = '';
            const createReplyContainer = document.getElementById(`createReplyContainer${feedbackId}`);
            createReplyContainer.style.display = 'none';

            // Re-render the feedback list
            renderFeedbackList();
        }

        function startEditReply(feedbackId, replyId) {
            const replyContentEl = document.getElementById(`replyContent${feedbackId}_${replyId}`);
            const currentMessage = feedbackData
                .find(f => f.id === feedbackId)
                .replies.find(r => r.id === replyId).message;

            replyContentEl.innerHTML = `
                <textarea class="reply-input" id="editReplyInput${feedbackId}_${replyId}">${currentMessage}</textarea>
                <button class="btn btn-edit" onclick="saveReply(${feedbackId}, ${replyId})">Save</button>
                <button class="btn btn-cancel" onclick="cancelEdit(${feedbackId}, ${replyId})">Cancel</button>
            `;
        }

        function saveReply(feedbackId, replyId) {
            const editInput = document.getElementById(`editReplyInput${feedbackId}_${replyId}`);
            const newMessage = editInput.value.trim();

            if (newMessage === '') {
                alert('Reply cannot be empty');
                return;
            }

            const feedback = feedbackData.find(f => f.id === feedbackId);
            const replyToUpdate = feedback.replies.find(r => r.id === replyId);
            
            replyToUpdate.message = newMessage;
            replyToUpdate.timestamp = new Date().toISOString().slice(0, 16).replace('T', ' ') + ' (Edited)';

            renderFeedbackList();
        }

        function cancelEdit(feedbackId, replyId) {
            renderFeedbackList();
        }

        function deleteReply(feedbackId, replyId) {
            const feedback = feedbackData.find(f => f.id === feedbackId);
            
            // Remove the specific reply
            feedback.replies = feedback.replies.filter(r => r.id !== replyId);

            renderFeedbackList();
        }

        // Initialize the feedback list on page load
        renderFeedbackList();